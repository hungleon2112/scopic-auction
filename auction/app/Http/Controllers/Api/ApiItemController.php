<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces_Service\IBidService;
use App\Abstracts\AEloquentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApiItemController extends Controller
{
    protected $itemService;
    protected $bidService;

    public function __construct(AEloquentService $itemService, IBidService $bidService)
    {
        $this->itemService = $itemService;
        $this->bidService = $bidService;
        $this->middleware('cors');
    }

    public function items()
    {
        $response = $this->itemService->itemList();
        return response()->json($response->content, $response->status);
    }

    public function item(Request $request)
    {
        $response = $this->itemService->itemDetail($request);
        return response()->json($response->content, $response->status);
    }

    public function itemsBid(Request $request)
    {
        $response = $this->bidService->listBiddingItem($request);
        return response()->json($response->content, $response->status);
    }

    public function itemsAwarded(Request $request)
    {
        $response = $this->bidService->listAwardedItem($request);
        return response()->json($response->content, $response->status);
    }

    public function bid(Request $request)
    {
        $response = $this->bidService->bid($request);
        return response()->json($response->content, $response->status);
    }
}
