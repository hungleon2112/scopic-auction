<?php
namespace App\Interfaces_Repository;

interface IBidRepository
{
    public function listBiddingItem($user_id);
    public function listAwardedItem($user_id);
}
