<?php

namespace App\Services;

use App\Enums\BadgeType;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GamificationService
{
    /**
     * Process all badge awards for a user after they win an auction.
     *
     * This is called by AuctionObserver::updated() when an auction's
     * status transitions to ENDED and a winner_id is set.
     */
    public function processWin(User $winner): void
    {
        // Count total auction wins for this user (fresh from DB)
        $winCount = $winner->wonAuctions()->count();

        Log::info("[GamificationService] Processing win for user #{$winner->id}. Total wins: {$winCount}");

        // Evaluate each badge in order of rarity
        foreach (BadgeType::cases() as $badgeType) {
            if ($winCount >= $badgeType->requiredWins()) {
                $this->awardBadge($winner, $badgeType);
            }
        }
    }

    /**
     * Award a badge to a user idempotently.
     *
     * Uses a check before attaching to the pivot to ensure a user
     * never receives the same badge twice, even if called concurrently.
     * The unique constraint on badge_user (badge_id, user_id) also
     * provides a database-level guarantee.
     */
    private function awardBadge(User $user, BadgeType $type): void
    {
        $badge = Badge::where('name', $type->value)->first();

        if (! $badge) {
            Log::warning("[GamificationService] Badge '{$type->value}' not found in database. Run db:seed.");
            return;
        }

        // Idempotent attach — only insert if not already awarded
        $alreadyAwarded = $user->badges()
            ->where('badge_id', $badge->id)
            ->exists();

        if ($alreadyAwarded) {
            return;
        }

        $user->badges()->attach($badge->id, [
            'awarded_at' => now(),
        ]);

        Log::info("[GamificationService] Awarded badge '{$type->value}' to user #{$user->id}");
    }
}
