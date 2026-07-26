<?php

namespace App\Http\Controllers;

use App\Enums\UserTier;
use Illuminate\Http\Request;

class TierController extends Controller
{

    public function upgrade(Request $request)
    {
        $user = auth()->user();


        if ($user->tier === UserTier::STANDARD) {


            if ($user->bids()->count() < 3) {
                return redirect()->back()->with('error', 'You need at least 3 bids to upgrade to Gold tier.');
            }


            $user->tier = UserTier::GOLD;
            $user->save();

            return redirect()->back()->with('success', 'Congratulations! You have been upgraded to the Gold tier.');
        }

        if ($user->tier === UserTier::GOLD) {


            if ($user->wonAuctions()->count() < 3) {
                return redirect()->back()->with('error', 'You need to win at least 2 auctions to unlock the VIP tier.');
            }


            $user->tier = UserTier::VIP;
            $user->save();

            return redirect()->back()->with('success', 'Amazing! You have reached the ultimate VIP tier.');
        }


        return redirect()->back()->with('error', 'You are already at the highest VIP tier!');
    }

}
