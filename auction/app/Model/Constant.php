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
    

    public const MESSAGE_INVALID_INPUT_UPDATE = "Invalid Input (Item ID or Date Time Format or This Bid cannot be updated)";
    public const MESSAGE_INVALID_INPUT = "Invalid Input (Item ID or Date Time Format)";
    public const MESSAGE_INVALID_CREDENTIALS = "Invalid Credentials";
    public const TOOLTIP_DISABLED_DELETE_BUTTON = 'Can not delete this item because it has related %s.';
}
