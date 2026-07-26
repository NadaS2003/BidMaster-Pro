<?php

namespace App\Observers;

use App\Enums\AuctionStatus;
use App\Jobs\CloseAuctionJob;
use App\Models\Auction;
use App\Models\User;
use App\Services\GamificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuctionObserver
{
    public function __construct(private readonly GamificationService $gamification)
    {
    }

    /**
     * Fired when a new auction is created.
     *
     * - Triggers AI evaluation of the auction description via Gemini
     * - Schedules the CloseAuctionJob to fire at the auction's end_time
     */
    public function created(Auction $auction): void
    {
        Log::info("[AuctionObserver] Auction created: #{$auction->id}");

        $this->analyzeAuctionTrust($auction);

        $endTime = Carbon::parse($auction->end_time)->timezone(config('app.timezone'));

        if ($endTime->isFuture()) {
            Log::info("[AuctionObserver] Dispatching CloseAuctionJob at {$endTime}");
            CloseAuctionJob::dispatch($auction)->delay($endTime);
        }
    }

    /**
     * Fired when an auction's attributes are updated.
     *
     * - If status transitions to ENDED and a winner is set,
     *   trigger the gamification engine to award badges.
     */
    public function updated(Auction $auction): void
    {
        $statusChanged = $auction->wasChanged('status');
        $isNowEnded    = $auction->status === AuctionStatus::ENDED;

        if ($statusChanged && $isNowEnded && $auction->winner_id) {
            Log::info("[AuctionObserver] Auction #{$auction->id} ended. Processing gamification for winner #{$auction->winner_id}.");

            $winner = User::find($auction->winner_id);

            if ($winner) {
                $this->gamification->processWin($winner);
            }
        }
    }

    /**
     * Call the Gemini API to evaluate the auction description for trust signals.
     * Stores the AI evaluation text on the auction model.
     */
    private function analyzeAuctionTrust(Auction $auction): void
    {
        $response = Http::withoutVerifying()
            ->timeout(60)
            ->connectTimeout(60)
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . env('GEMINI_API_KEY'),
                [
                    'contents' => [
                        ['parts' => [['text' => 'Analyze the following auction listing for trustworthiness and authenticity. Provide a brief evaluation: ' . $auction->description]]]
                    ],
                ]
            );

        if ($response->successful()) {
            $evaluation = $response->json('candidates.0.content.parts.0.text');
            $auction->update(['ai_evaluation' => $evaluation]);
        } else {
            Log::error("[AuctionObserver] Gemini API Error for auction #{$auction->id}: " . $response->body());
        }
    }
}
