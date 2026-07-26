<?php

use App\Console\Commands\ActivateUpcomingAuctions;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Auction Lifecycle Scheduling
|--------------------------------------------------------------------------
|
| Activate upcoming auctions every minute when their start_time is reached.
| CloseAuctionJob handles auction endings via delayed dispatch on creation.
|
*/
Schedule::command(ActivateUpcomingAuctions::class)->everyMinute();
