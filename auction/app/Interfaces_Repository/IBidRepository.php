<?php
namespace App\Interfaces_Repository;

interface IBidRepository
{
    public function listBiddingItem($user_id);
    public function listAwardedItem($user_id);
    public function listBidDetailOfBidExceptUser($bid_id, $user_id);
}
