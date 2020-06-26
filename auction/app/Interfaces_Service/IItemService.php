<?php
namespace App\Interfaces_Service;
use Illuminate\Http\Request;

interface IItemService
{
    public function bid(Request $request);
    public function bidUpdate(Request $request);
}
