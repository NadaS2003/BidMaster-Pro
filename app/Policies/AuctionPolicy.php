<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;

class AuctionPolicy
{
    /**
     * Determine if the user can view (access) this auction.
     *
     * Tier-gated auctions require the user's tier to meet or exceed
     * the auction's minimum_tier setting.
     */
    public function view(User $user, Auction $auction): bool
    {
        return $user->hasTier($auction->minimum_tier);
    }

    /**
     * Determine if the user can update this auction.
     * Only the seller can edit their own auction.
     */
    public function update(User $user, Auction $auction): bool
    {
        return $user->id === $auction->user_id;
    }

    /**
     * Determine if the user can delete this auction.
     * The seller or an admin can delete an auction.
     */
    public function delete(User $user, Auction $auction): bool
    {
        return $user->id === $auction->user_id
            || ($user->is_admin ?? false);
    }

    /**
     * Determine if the user can place a bid on this auction.
     *
     * Rules:
     *  - The auction seller cannot bid on their own auction
     *  - The bidder's tier must meet the auction's minimum tier
     */
    public function bid(User $user, Auction $auction): bool
    {
        if ($user->id === $auction->user_id) {
            return false;
        }

        return $user->hasTier($auction->minimum_tier);
    }
}
