<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserTier;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['name', 'email', 'password', 'tier'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'tier'              => UserTier::class,
        ];
    }

    // ─────────────────────────────────────────────
    // Relations
    // ─────────────────────────────────────────────

    /**
     * Auctions created (listed) by this user.
     */
    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    /**
     * All bids placed by this user.
     */
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Auctions this user has won.
     */
    public function wonAuctions(): HasMany
    {
        return $this->hasMany(Auction::class, 'winner_id');
    }

    /**
     * Gamification badges earned by this user.
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class)
            ->withPivot('awarded_at')
            ->orderByPivot('awarded_at', 'desc');
    }

    // ─────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────

    /**
     * Check if this user's tier meets the required minimum tier.
     */
    public function hasTier(UserTier $required): bool
    {
        return $this->tier->meetsMinimum($required);
    }
}
