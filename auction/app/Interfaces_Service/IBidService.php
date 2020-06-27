<?php
namespace App\Interfaces_Service;
use Illuminate\Http\Request;

interface IBidService
{
    public function createBidForItem(Request $request);
    public function updateBidForItem(Request $request);
    public function listBiddingItem();
    public function listAwardedItem();
    public function bid(Request $request);
}
