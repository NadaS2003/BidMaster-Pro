<?php

namespace App\Providers;

use App\Enums\AuctionStatus;
use App\Enums\UserTier;
use App\Http\Middleware\RequireAccountTier;
use App\Models\Auction;
use App\Models\User;
use App\Observers\AuctionObserver;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── Model Observers ───────────────────────────────────────────────
        Auction::observe(AuctionObserver::class);

        // ── Livewire Components ───────────────────────────────────────────
        Livewire::component('auction-status', \App\Livewire\AuctionStatus::class);

        // ── Account Tier Gates ────────────────────────────────────────────
        // These gates can be used with @can / Gate::allows() in views & controllers.
        // They also power the tier-based auction access control.

        Gate::define('access-gold-auction', function (User $user): bool {
            return $user->tier->meetsMinimum(UserTier::GOLD);
        });

        Gate::define('access-vip-auction', function (User $user): bool {
            return $user->tier->meetsMinimum(UserTier::VIP);
        });

        Gate::define('access-auction', function (User $user, Auction $auction): bool {
            return $user->tier->meetsMinimum($auction->minimum_tier);
        });

        // ── Register Middleware Alias ─────────────────────────────────────
        // Allows: Route::middleware('tier:gold')->...
        $this->app['router']->aliasMiddleware('tier', RequireAccountTier::class);
    }
}
