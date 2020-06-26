<?php
namespace App\Interfaces_Service;
use Illuminate\Http\Request;

interface IItemService
{
    public function createBidForItem(Request $request);
    public function updateBidForItem(Request $request);
}
