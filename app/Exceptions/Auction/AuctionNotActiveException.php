<?php

namespace App\Exceptions\Auction;

use Exception;

class AuctionNotActiveException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'This auction is not currently active and is not accepting bids.'
        );
    }
}
