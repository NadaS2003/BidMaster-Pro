<?php

namespace App\Http\Controllers;

use App\Events\BidPlaced;
use App\Exceptions\Auction\AuctionExpiredException;
use App\Exceptions\Auction\AuctionNotActiveException;
use App\Exceptions\Auction\BidTooLowException;
use App\Http\Requests\PlaceBidRequest;
use App\Models\Auction;
use App\Services\BidService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BidController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly BidService $bidService)
    {
    }

    /**
     * Display all auctions where the authenticated user has placed a bid.
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $auctions = Auction::whereHas('bids', fn ($q) => $q->where('user_id', $userId))
            ->withMax(['bids as my_highest_bid' => fn ($q) => $q->where('user_id', $userId)], 'amount')
            ->withMax('bids as current_highest_bid', 'amount')
            ->latest()
            ->paginate(9);

        return view('bids.active', compact('auctions'));
    }

    /**
     * Place a bid on an auction.
     *
     * Flow:
     *  1. Authorize via AuctionPolicy::bid()
     *  2. Validate HTTP request via PlaceBidRequest
     *  3. Delegate ALL business logic to BidService (with pessimistic locking)
     *  4. Dispatch BidPlaced event for real-time broadcast via Reverb
     *  5. Return redirect with success or field errors
     */
    public function store(PlaceBidRequest $request, Auction $auction): RedirectResponse
    {
        // Policy check: prevents auction owner from bidding on their own auction
        $this->authorize('bid', $auction);

        try {
            $bid = $this->bidService->placeBid(
                auction: $auction,
                user:    $request->user(),
                amount:  (float) $request->validated('amount'),
            );

            // Load relations needed by the broadcast payload
            $bid->load('bidder', 'auction');

            // Broadcast real-time update to all listeners on this auction channel
            BidPlaced::dispatch($bid);

            return back()->with('success', 'Your bid has been placed successfully!');

        } catch (BidTooLowException $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);

        } catch (AuctionNotActiveException|AuctionExpiredException $e) {
            return back()->withErrors(['amount' => $e->getMessage()]);
        }
    }
}
