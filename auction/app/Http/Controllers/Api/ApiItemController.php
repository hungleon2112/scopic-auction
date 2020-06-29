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

    /**
         * @SWG\Get(
         *     path="/api/v1/items",
         *     description="List Item",
        *     @SWG\Parameter(
        *         name="Authorization",
        *         in="header",
        *         description="Bearer",
        *         required=true,
        *         type="string",
        *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="{'data' : [{ bid:{}, bid_detail:[{}], item:{} }] }",
         *     ),
         *     @SWG\Response(
         *         response=401,
         *         description="{'error' : 'Token Absent / Expired'}"
         *     )
         * )
    */
    public function items()
    {
        $response = $this->itemService->itemList();
        return response()->json($response->content, $response->status);
    }


    /**
         * @SWG\Get(
         *     path="/api/v1/item",
         *     description="Detail Item",
        *     @SWG\Parameter(
        *         name="Authorization",
        *         in="header",
        *         description="Bearer",
        *         required=true,
        *         type="string",
        *     ),
         *     @SWG\Parameter(
         *         name="item_id",
         *         in="query",
         *         type="string",
         *         description="Item ID",
         *         required=true,
         *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="{'data' : { bid:{}, bid_detail:[{}], item:{} } }",
         *     ),
         *     @SWG\Response(
         *         response=401,
         *         description="{'error' : 'Token Absent / Expired'}"
         *     )
         * )
    */
    public function item(Request $request)
    {
        $response = $this->itemService->itemDetail($request);
        return response()->json($response->content, $response->status);
    }


    /**
         * @SWG\Get(
         *     path="/api/v1/items-bid",
         *     description="List Item have Bid",
        *     @SWG\Parameter(
        *         name="Authorization",
        *         in="header",
        *         description="Bearer",
        *         required=true,
        *         type="string",
        *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="{'data' : [{name, bid_id, bid_detail_winner, closed_date, desc, id, image, status}] }",
         *     ),
         *     @SWG\Response(
         *         response=401,
         *         description="{'error' : 'Token Absent / Expired'}"
         *     )
         * )
    */
    public function itemsBid(Request $request)
    {
        $response = $this->bidService->listBiddingItem($request);
        return response()->json($response->content, $response->status);
    }


    /**
         * @SWG\Get(
         *     path="/api/v1/items-awarded",
         *     description="List Item have Awarded",
        *     @SWG\Parameter(
        *         name="Authorization",
        *         in="header",
        *         description="Bearer",
        *         required=true,
        *         type="string",
        *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="{'data' : [{name, bid_id, closed_date, desc, id, image, status, price}] }",
         *     ),
         *     @SWG\Response(
         *         response=401,
         *         description="{'error' : 'Token Absent / Expired'}"
         *     )
         * )
    */
    public function itemsAwarded(Request $request)
    {
        $response = $this->bidService->listAwardedItem($request);
        return response()->json($response->content, $response->status);
    }

    /**
         * @SWG\Post(
         *     path="/api/v1/bid",
         *     description="Make Bid",
        *     @SWG\Parameter(
        *         name="Authorization",
        *         in="header",
        *         description="Bearer",
        *         required=true,
        *         type="string",
        *     ),
        *     @SWG\Parameter(
        *          name="body",
        *          in="body",
        *          required=true,
        *          @SWG\Schema(
        *              @SWG\Property(
        *                  property="price",
        *                  type="number"
        *              ),
        *              @SWG\Property(
        *                  property="item_id",
        *                  type="string"
        *              )
        *          )
        *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="{'data' : Request Success }",
         *     ),
         *     @SWG\Response(
         *         response=401,
         *         description="{'error' : 'Token Absent / Expired'}"
         *     )
         * )
    */
    public function bid(Request $request)
    {
        $response = $this->bidService->bid($request);
        return response()->json($response->content, $response->status);
    }
}
