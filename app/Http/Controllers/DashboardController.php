<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Badge;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $activeBidsCount = $user->bids()->distinct('auction_id')->count();

        $myAuctionsCount = $user->auctions()->count();

        $endingSoonAuctions = Auction::where('status', 'active')
        ->where('end_time', '>', Carbon::now())
            ->where('end_time', '<=', Carbon::now()->addHours(24))
            ->take(4)
            ->get();

        $badges = Badge::all()->map(function ($badge) use ($user) {
            $badge->is_unlocked = $user->badges->contains($badge->id);
            return $badge;
        });


        $totalBidsCount = $user->bids()->count();


        $recentBids = $user->bids()
            ->with('auction')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'activeBidsCount',
            'myAuctionsCount',
            'totalBidsCount',
            'recentBids',
            'endingSoonAuctions',
            'badges'
        ));
    }
}
