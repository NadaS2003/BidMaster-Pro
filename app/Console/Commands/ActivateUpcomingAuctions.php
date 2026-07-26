<?php

namespace App\Console\Commands;

use App\Enums\AuctionStatus;
use App\Models\Auction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ActivateUpcomingAuctions extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'auctions:activate-upcoming';

    /**
     * The console command description.
     */
    protected $description = 'Transition auctions from UPCOMING to ACTIVE when their start_time has been reached.';

    /**
     * Execute the console command.
     *
     * Runs every minute via scheduler (see routes/console.php).
     * Finds all UPCOMING auctions whose start_time <= now and flips them to ACTIVE.
     */
    public function handle(): void
    {
        $count = Auction::query()
            ->where('status', AuctionStatus::UPCOMING)
            ->where('start_time', '<=', now())
            ->update(['status' => AuctionStatus::ACTIVE]);

        if ($count > 0) {
            Log::info("[ActivateUpcomingAuctions] Activated {$count} auction(s).");
            $this->info("Activated {$count} auction(s).");
        } else {
            $this->info('No upcoming auctions to activate.');
        }
    }
}
