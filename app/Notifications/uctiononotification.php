<?php

namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class uctiononotification extends Notification
{
    use Queueable;

    public Auction $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }


    public function via(object $notifiable): array
    {
        return [
            'database',
            'broadcast',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'auction_id' => $this->auction->id,
            'title' => 'You won the auction!',
            'message' => "Congratulations! You won {$this->auction->title}",
        ]);
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'auction_id' => $this->auction->id,
            'title' => 'You won the auction!',
            'message' => "Congratulations! You won {$this->auction->title}",
        ];
    }
}
