<?php

namespace App\Enums;

enum UserTier: string
{
    case STANDARD = 'standard';
    case GOLD     = 'gold';
    case VIP      = 'vip';

    /**
     * Numeric rank for easy comparison (higher = more privileged).
     */
    public function rank(): int
    {
        return match($this) {
            self::STANDARD => 1,
            self::GOLD     => 2,
            self::VIP      => 3,
        };
    }

    /**
     * Check if this tier satisfies a minimum tier requirement.
     */
    public function meetsMinimum(self $required): bool
    {
        return $this->rank() >= $required->rank();
    }

    /**
     * Human-readable label for display.
     */
    public function label(): string
    {
        return match($this) {
            self::STANDARD => 'Standard',
            self::GOLD     => 'Gold',
            self::VIP      => 'VIP',
        };
    }

    /**
     * Badge/icon colour class for UI rendering.
     */
    public function colorClass(): string
    {
        return match($this) {
            self::STANDARD => 'text-gray-500',
            self::GOLD     => 'text-yellow-500',
            self::VIP      => 'text-purple-500',
        };
    }
}
