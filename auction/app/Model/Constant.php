<?php

namespace App\Model;

class Constant
{
    public const ROLE_REGULAR = 1;
    public const ROLE_ADMIN = 2;

    public const BID_STATUS_IN_PROGRESS = 1;
    public const BID_STATUS_IN_COMPLETED = 2;
    public const BID_STATUS_LABEL = [
        self::BID_STATUS_IN_PROGRESS => "In Progress",
        self::BID_STATUS_IN_COMPLETED => "Completed",
    ];
    
}
