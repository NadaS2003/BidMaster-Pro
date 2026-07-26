<?php

namespace App\Notifications;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notification sent to the winner of an auction.
 *
 * Channels:
 *  - mail:      Rich email via MailMessage
 *  - database:  Stored for in-app notification center
 *  - broadcast: Real-time push via Laravel Reverb (private channel)
 */
class AuctionWinNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public readonly Auction $auction)
    {
    }

    /**
     * Delivery channels: email + database + real-time broadcast.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Email notification with auction details and CTA.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("🎉 Congratulations! You Won: {$this->auction->title}")
            ->greeting("Hello, {$notifiable->name}!")
            ->line("Great news — you've won the auction for **{$this->auction->title}**.")
            ->line('**Final Price:** $' . number_format((float) $this->auction->current_price, 2))
            ->action('View Your Auction', url("/auctions/{$this->auction->id}"))
            ->line('Thank you for participating in Smart Auction!');
    }

    /**
     * Database notification payload (stored in notifications table).
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'auction_id'    => $this->auction->id,
            'auction_title' => $this->auction->title,
            'final_price'   => $this->auction->current_price,
            'title'         => '🏆 You won the auction!',
            'message'       => "Congratulations! You won \"{$this->auction->title}\".",
        ];
    }

    /**
     * Real-time broadcast payload to the user's private channel.
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'auction_id'    => $this->auction->id,
            'auction_title' => $this->auction->title,
            'final_price'   => $this->auction->current_price,
            'title'         => '🏆 You won the auction!',
            'message'       => "Congratulations! You won \"{$this->auction->title}\".",
        ]);
    }
}
