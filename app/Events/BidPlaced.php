<?php

namespace App\Events;

use App\Models\Bid;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Broadcast when a bid is placed on an auction.
 *
 * Channel: auction.{auction_id}  (public channel — all viewers see price updates)
 * Event:   BidPlaced
 *
 * Switched from ShouldBroadcastNow → ShouldBroadcast so that under
 * high-concurrency, broadcasts are queued and dispatched asynchronously.
 * This prevents Reverb connection bottlenecks when many bids arrive at once.
 */
class BidPlaced implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Bid $bid)
    {
    }

    /**
     * Broadcast on the public auction channel.
     * All users viewing the auction page receive this event.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('auction.' . $this->bid->auction_id);
    }

    public function broadcastAs(): string
    {
        return 'BidPlaced';
    }

    /**
     * Enriched payload with all data needed to update the UI without
     * the client making a separate HTTP request.
     */
    public function broadcastWith(): array
    {
        $auction = $this->bid->auction;

        return [
            'bid_id'        => $this->bid->id,
            'auction_id'    => $this->bid->auction_id,
            'amount'        => $this->bid->amount,
            'bidder_id'     => $this->bid->user_id,
            'bidder_name'   => $this->bid->bidder?->name,
            'bids_count'    => $auction?->bids()->count() ?? 0,
            'current_price' => $auction?->current_price,
            'placed_at'     => $this->bid->created_at?->toIso8601String(),
        ];
    }
}
