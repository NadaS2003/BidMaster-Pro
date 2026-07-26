<?php

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TierController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuctionController::class, 'index'])->name('home');
Route::get('/upcoming', [AuctionController::class, 'upcoming'])->name('auctions.upcoming');
Route::get('/results', [AuctionController::class, 'results'])->name('auctions.results');

Route::middleware(['auth'])->group(function () {

    Route::resource('auctions', AuctionController::class);
//   ->except(['index', 'show'])
    Route::post('/auctions/{auction}/bid', [BidController::class, 'store'])->name('bids.store');

    Route::get('/dashboard',DashboardController::class)->name('dashboard');
    Route::get('/my-auctions', [AuctionController::class, 'myAuctions'])->name('auctions.my');
    Route::get('/active-bids', [BidController::class, 'index'])->name('bids.active');
    Route::post('/upgrade-tier', [TierController::class, 'upgrade'])->name('tier.upgrade');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.update-profile');
    Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.update-password');
});

//Route::resource('auctions', AuctionController::class)->only(['index', 'show']); // السماح بعرض المزادات فقط للزوار


