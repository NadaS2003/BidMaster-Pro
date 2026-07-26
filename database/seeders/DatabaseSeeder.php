<?php

namespace Database\Seeders;

use App\Enums\BadgeType;
use App\Models\Auction;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Gamification: Seed all badge types ───────────────────────────
        // Uses upsert to be idempotent — safe to run multiple times.
        $badges = array_map(fn (BadgeType $type) => [
            'name'        => $type->value,
            'description' => $type->description(),
            'icon_path'   => null,
        ], BadgeType::cases());

        Badge::upsert($badges, uniqueBy: ['name'], update: ['description']);

        $this->command->info('✓ Badges seeded: ' . implode(', ', array_column($badges, 'name')));

        // ── Sample Data ───────────────────────────────────────────────────
        User::factory(10)->create();
        Auction::factory(5)->create(['user_id' => 1]);
    }
}
