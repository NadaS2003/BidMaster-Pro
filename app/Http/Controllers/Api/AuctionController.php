<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Auction;

class AuctionController extends Controller
{

    public function show(Auction $auction)
    {
        return response()->json([
            'success' => true,

            'auction' => [
                'id' => $auction->id,
                'title' => $auction->title,
                'description' => $auction->description,
                'current_price' => $auction->current_price,
                'status' => $auction->status->value,
                'total_bids' => $auction->bids()->count(),
                'seller' => $auction->seller->name,
            ]
        ]);
    }

}
