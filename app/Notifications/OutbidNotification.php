<?php
namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class OutbidNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Auction $auction)
    {
    }

    public function via($notifiable)
    {
        return [
            'database',
            'broadcast',
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'auction_id' => $this->auction->id,
            'title' => 'You have been outbid!',
            'message' => "Someone placed a higher bid on {$this->auction->title}.",
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'auction_id' => $this->auction->id,
            'title' => 'You have been outbid!',
            'message' => "Someone placed a higher bid on {$this->auction->title}.",
        ]);
    }
}
