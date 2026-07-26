<?php

namespace Database\Factories;

use App\Enums\AuctionStatus;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // ينشئ مستخدم تلقائياً ويربط المزاد به
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'starting_price' => $this->faker->randomFloat(2, 10, 500),
            'current_price' => null,
            'status' => AuctionStatus::ACTIVE,
            'end_time' => now()->addDays(rand(1, 7)), // ينتهي في تاريخ مستقبلي عشوائي
        ];
    }
}
