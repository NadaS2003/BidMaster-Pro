<?php

namespace App\Services;

use App\Enums\AuctionStatus;
use App\Exceptions\Auction\AuctionExpiredException;
use App\Exceptions\Auction\AuctionNotActiveException;
use App\Exceptions\Auction\BidTooLowException;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use App\Notifications\OutbidNotification;
use Illuminate\Support\Facades\DB;

class BidService
{
    /**
     * Place a bid on an auction with full pessimistic locking.
     *
     * This method wraps everything in a DB::transaction with a
     * SELECT ... FOR UPDATE lock on the auction row. This ensures
     * that under high-concurrency, only one request can read and
     * modify the auction row at a time. Concurrent requests will
     * wait at the lock boundary, then re-evaluate with fresh data.
     *
     * @throws AuctionNotActiveException
     * @throws AuctionExpiredException
     * @throws BidTooLowException
     */
    public function placeBid(Auction $auction, User $user, float $amount): Bid
    {
        return DB::transaction(function () use ($auction, $user, $amount) {

            // ── PESSIMISTIC LOCK ──────────────────────────────────────────
            // SELECT ... FOR UPDATE acquires an exclusive row lock.
            // Any concurrent transaction attempting to read/write this
            // auction row will block here until we COMMIT or ROLLBACK.
            // This eliminates the race condition where two simultaneous
            // bids both read the same current_price and both "win".
            // ─────────────────────────────────────────────────────────────
            $auction = Auction::lockForUpdate()->findOrFail($auction->id);

            // Guard 1: Auction must be in ACTIVE status
            if ($auction->status !== AuctionStatus::ACTIVE) {
                throw new AuctionNotActiveException();
            }

            // Guard 2: Auction must not have passed its deadline
            // (Checked AFTER lock to avoid TOCTOU — time-of-check/time-of-use)
            if (now()->gte($auction->end_time)) {
                throw new AuctionExpiredException();
            }

            // Guard 3: Bid amount must strictly exceed current price
            // نحدد السعر الأدنى المقبول بناءً على وجود مزايدات سابقة أو الاعتماد على سعر البداية
            $minAllowedBid = (float) ($auction->current_price ?? $auction->starting_price);

            if ($amount <= $minAllowedBid) {
                // استثناء خاص للمزايدة الأولى: إذا لم يكن هناك مزايدات، نقبل أي مبلغ يساوي أو أكبر من سعر البداية
                if ($auction->current_price === null && $amount >= (float) $auction->starting_price) {
                    // هذه حالة صحيحة، نمررها (نكمل العملية)
                } else {
                    // هذه الحالة تعني أن السعر المدخل أقل من السعر المطلوب
                    throw new BidTooLowException($minAllowedBid);
                }
            }

            // ── Capture outbid user BEFORE creating the new bid ───────────
            // We load with 'bidder' to avoid N+1 when sending notification.
            $previousTopBid = $auction->bids()
                ->orderByDesc('amount')
                ->with('bidder')
                ->first();

            // ── Create the winning bid record ─────────────────────────────
            $bid = Bid::create([
                'auction_id' => $auction->id,
                'user_id'    => $user->id,
                'amount'     => $amount,
            ]);

            // ── Atomically update the auction's current price ─────────────
            // Using update() rather than save() to avoid overwriting other
            // columns that may have changed since we loaded the model.
            $auction->update(['current_price' => $amount]);

            // ── Notify the outbid user (queued) ───────────────────────────
            // Notification is dispatched inside the transaction scope.
            // Queued notifications are safe here: they are pushed to the
            // queue AFTER commit by Laravel's transactional awareness.
            if ($previousTopBid
                && $previousTopBid->user_id !== $user->id
                && $previousTopBid->bidder !== null
            ) {
                $previousTopBid->bidder->notify(new OutbidNotification($auction));
            }

            return $bid;
        });
    }
}
