<?php namespace App\Traits;

use App\DTO\BasicResponseModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;
use App\Mail\BasicMail;
use Illuminate\Support\Facades\Mail;
use App\Model\Constant;

trait TraitsSendEmail
{
    public static function sendEmailTowinner($user, $item, $price)
    {
        Mail::to($user->email)->send(new BasicMail([
            'name' => $user->name,
            'item' => $item,
            'price' => $price,
        ], Constant::MAIL_TYPE_WINNER));
    }

    public static function sendEmailToOtherAuctioneer($user, $item, $price)
    {
        Mail::to($user->email)->send(new BasicMail([
            'name' => $user->name,
            'item' => $item,
            'price' => $price,
        ], Constant::MAIL_TYPE_OTHER_AUCTIONEER));
    }
}
