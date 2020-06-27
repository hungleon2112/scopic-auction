<?php
namespace App\Repositories;

use App\Abstracts\AEloquentRepository;
use App\Interfaces_Repository\IBidRepository;
use App\Model\Bids;
use App\Model\BidDetails;
use App\Model\Constant;
use Illuminate\Support\Facades\DB;

class BidRepository extends AEloquentRepository implements IBidRepository
{
// model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(
        Bids $model
    )
    {
        $this->model = $model;
    }

    public function create($data){
        $user = $this->model->create($data);
        return $user;
    }

    public function listBiddingItem($user_id){
        $bids = $this->model
        ->join('bid_details', 'bids.id', '=', 'bid_details.bid_id')
        ->join('items', 'bids.item_id', '=', 'items.id')
        ->where('user_id', '=', $user_id)
        ->select(['items.name', 'items.image', 'items.id', 'items.desc', 'bids.closed_date', 'bids.status'])
        ->get();

        return $bids;
    }

    public function listAwardedItem($user_id){

        $bids = $this->model
        ->join('bid_details', 'bids.id', '=', 'bid_details.bid_id')
        ->join('items', 'bids.item_id', '=', 'items.id')
        ->where('user_id', '=', $user_id)
        ->where('status', '=', Constant::BID_STATUS_COMPLETED)
        ->whereIn('bid_details.price', function($query){
            $query->select(DB::raw('max(price) as maxprice'))
            ->from('bid_details')
            ->groupBy('bid_id');
        })
        ->select(['items.name', 'items.image', 'items.id', 'items.desc', 'bids.closed_date', 'bids.status', 'bid_details.price'])
        ->get();

        return $bids;
    }

    public function bid($bid_id, $user_id, $price)
    {
        $bid_detail = BidDetails::create([
            'bid_id' => $bid_id,
            'user_id' => $user_id,
            'price' => $price,
        ]);

        return $bid_detail;
    }

}
