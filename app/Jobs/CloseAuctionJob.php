<?php

namespace App\Jobs;

use App\Enums\AuctionStatus;
use App\Events\AuctionEnded;
use App\Models\Auction;
use App\Notifications\AuctionWinNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CloseAuctionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     * With 3 retries + unique locking this is safe against transient DB errors.
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 60;

    public function __construct(public readonly Auction $auction)
    {
    }

    /**
     * Close an auction, determine the winner, broadcast the result, and notify the winner.
     *
     * This method uses SELECT ... FOR UPDATE (pessimistic locking) on the auction row
     * to ensure that if two CloseAuctionJob instances somehow run simultaneously for
     * the same auction (e.g., duplicate delayed jobs), only one will proceed.
     * The second will find status=ENDED and exit cleanly.
     */
    public function handle(): void
    {
        DB::transaction(function () {

            // ── PESSIMISTIC LOCK ──────────────────────────────────────────
            // Prevents a duplicate job run from processing the same auction twice.
            // ─────────────────────────────────────────────────────────────
            $auction = Auction::lockForUpdate()->find($this->auction->id);

            if (! $auction) {
                Log::warning("[CloseAuctionJob] Auction #{$this->auction->id} not found. Skipping.");
                return;
            }

            if ($auction->status === AuctionStatus::ENDED) {
                Log::info("[CloseAuctionJob] Auction #{$auction->id} already ended. Skipping duplicate run.");
                return;
            }

            // Fetch the highest bid — one query with eager loaded bidder
            $highestBid = $auction->bids()
                ->orderByDesc('amount')
                ->with('bidder')
                ->first();

            Log::info("[CloseAuctionJob] Closing auction #{$auction->id}. Winner: " . ($highestBid?->user_id ?? 'none'));

            // Atomically mark auction as ended and assign winner
            $auction->update([
                'status'    => AuctionStatus::ENDED,
                'winner_id' => $highestBid?->user_id,
            ]);

            // Refresh to get updated attributes for the event payload
            $auction->refresh();

            // Broadcast AuctionEnded event to Reverb (real-time for all viewers)
            AuctionEnded::dispatch($auction);

            // Send winner notification (mail + database + broadcast)
            if ($highestBid && $highestBid->bidder) {
                $highestBid->bidder->notify(new AuctionWinNotification($auction));
            }
        });
    }
}
