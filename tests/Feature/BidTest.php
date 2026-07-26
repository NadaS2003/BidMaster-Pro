<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Auction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BidTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_place_a_bid_on_active_auction()
    {
        $user = User::factory()->create();

        $auction = Auction::factory()->create([
            'start_time' => now()->subHour(),
            'end_time' => now()->addHour(),
            'starting_price' => 1000,
            'current_price' => 1000,
        ]);


        $response = $this
            ->actingAs($user)
            ->post(route('bids.store', $auction), [
                'amount' => 1200,
            ]);


        $response->assertSessionHasNoErrors();


        $this->assertDatabaseHas('bids', [
            'user_id' => $user->id,
            'auction_id' => $auction->id,
            'amount' => 1200,
        ]);
    }
}
