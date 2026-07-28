<?php

namespace App\Console\Commands;

use App\Enums\AuctionStatus;
use App\Events\AuctionEnded;
use App\Models\Auction;
use App\Notifications\AuctionWinNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CloseExpiredAuctions extends Command
{
    protected $signature = 'auctions:close-expired';
    protected $description = 'Close auctions whose end time has passed';

    public function handle()
    {
        // جلب كل المزادات التي انتهى وقتها لكنها لا تزال active
        $expiredAuctions = Auction::where('status', AuctionStatus::ACTIVE)
            ->where('end_time', '<=', now())
            ->get();

        foreach ($expiredAuctions as $auction) {
            DB::transaction(function () use ($auction) {
                $highestBid = $auction->bids()
                    ->orderByDesc('amount')
                    ->with('bidder')
                    ->first();

                $auction->update([
                    'status'    => AuctionStatus::ENDED,
                    'winner_id' => $highestBid?->user_id,
                ]);

                $auction->refresh();

                // إطلاق الحدث والإشعار
                AuctionEnded::dispatch($auction);

                if ($highestBid && $highestBid->bidder) {
                    $highestBid->bidder->notify(new AuctionWinNotification($auction));
                }
            });

            $this->info("Closed auction #{$auction->id}");
        }
    }
}
