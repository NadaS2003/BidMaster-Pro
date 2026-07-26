<?php

namespace App\Models;

use App\Enums\AuctionStatus;
use App\Enums\UserTier;
use App\Policies\AuctionPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(AuctionPolicy::class)]
class Auction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'image_path',
        'starting_price',
        'current_price',
        'status',
        'start_time',      // Added: was missing from fillable
        'end_time',
        'minimum_tier',    // Added: tier gating feature
        'ai_evaluation',
        'winner_id',
    ];

    protected function casts(): array
    {
        return [
            'status'       => AuctionStatus::class,
            'minimum_tier' => UserTier::class,
            'start_time'   => 'datetime',
            'end_time'     => 'datetime',
            'starting_price' => 'decimal:2',
            'current_price'  => 'decimal:2',
        ];
    }

    // ─────────────────────────────────────────────
    // Relations
    // ─────────────────────────────────────────────

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->orderByDesc('amount');
    }

    // ─────────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', AuctionStatus::ACTIVE);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('status', AuctionStatus::UPCOMING);
    }

    public function scopeEnded(Builder $query): Builder
    {
        return $query->where('status', AuctionStatus::ENDED);
    }

    /**
     * Scope to only auctions accessible by a given tier level.
     */
    public function scopeAccessibleByTier(Builder $query, UserTier $tier): Builder
    {
        $allowedTiers = match ($tier) {
            UserTier::VIP      => ['standard', 'gold', 'vip'],
            UserTier::GOLD     => ['standard', 'gold'],
            UserTier::STANDARD => ['standard'],
        };

        return $query->whereIn('minimum_tier', $allowedTiers);
    }
}
