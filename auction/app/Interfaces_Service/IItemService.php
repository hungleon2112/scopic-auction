<?php
namespace App\Interfaces_Service;
use Illuminate\Http\Request;

interface IItemService
{
    public function itemList();
    public function itemDetail(Request $request);
}
