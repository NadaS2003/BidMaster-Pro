<?php

namespace App\Exceptions\Auction;

use Exception;

class BidTooLowException extends Exception
{
    public function __construct(float $currentPrice)
    {
        parent::__construct(
            sprintf(
                'Your bid must be strictly higher than the current price of $%s.',
                number_format($currentPrice, 2)
            )
        );
    }
}
