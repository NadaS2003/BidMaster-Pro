<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionEnded implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public Auction $auction;


    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }


    public function broadcastOn()
    {
        return new Channel(
            'auction.' . $this->auction->id
        );
    }


    public function broadcastAs()
    {
        return 'AuctionEnded';
    }


    public function broadcastWith()
    {
        return [
            'winner' => $this->auction->winner?->name ?? 'NO WINNER',
            'price' => $this->auction->current_price,
        ];
    }
}
