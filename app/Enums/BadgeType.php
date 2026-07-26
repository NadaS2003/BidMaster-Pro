<?php

namespace App\Enums;

enum BadgeType: string
{
    case FIRST_WIN  = 'Auction Winner';
    case TOP_BIDDER = 'Top Bidder';
    case VIP_BIDDER = 'VIP Bidder';

    /**
     * The number of auction wins required to earn this badge.
     */
    public function requiredWins(): int
    {
        return match($this) {
            self::FIRST_WIN  => 1,
            self::TOP_BIDDER => 3,
            self::VIP_BIDDER => 5,
        };
    }

    /**
     * Description shown on the badge card.
     */
    public function description(): string
    {
        return match($this) {
            self::FIRST_WIN  => 'Won your first auction.',
            self::TOP_BIDDER => 'Won 3 or more auctions.',
            self::VIP_BIDDER => 'Won 5 or more auctions — an elite bidder.',
        };
    }
}
