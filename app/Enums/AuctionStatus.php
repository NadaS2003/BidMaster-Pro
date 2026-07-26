<?php

namespace App\Enums;

enum AuctionStatus : string
{
    case ACTIVE = 'active';
    case ENDED = 'ended';
    case CANCELED = 'canceled';

    case UPCOMING = 'upcoming';

}
