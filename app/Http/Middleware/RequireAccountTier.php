<?php

namespace App\Http\Middleware;

use App\Enums\UserTier;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to enforce account tier access on routes.
 *
 * Usage in routes:
 *   Route::middleware('tier:gold')->group(...)
 *   Route::middleware('tier:vip')->group(...)
 *
 * Usage with route model (e.g., for tier-gated auctions):
 *   $this->middleware('tier:' . $auction->minimum_tier->value);
 */
class RequireAccountTier
{
    public function handle(Request $request, Closure $next, string $requiredTier = 'standard'): Response
    {
        $user = $request->user();

        // Unauthenticated users are redirected to login
        if (! $user) {
            return redirect()->route('login');
        }

        $required     = UserTier::from($requiredTier);
        $userTier     = $user->tier instanceof UserTier
            ? $user->tier
            : UserTier::from($user->tier);

        if (! $userTier->meetsMinimum($required)) {
            abort(403, "This auction requires a {$required->label()} account tier or higher. Your current tier is {$userTier->label()}.");
        }

        return $next($request);
    }
}
