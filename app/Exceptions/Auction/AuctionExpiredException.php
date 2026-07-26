<?php

namespace App\Exceptions\Auction;

use Exception;

class AuctionExpiredException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'This auction has already concluded and is no longer accepting bids.'
        );
    }
}
