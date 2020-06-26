<?php

namespace App\Model;
use App\Model\Constant;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $table = 'bids';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id', 'status' , 'closed_date'
    ];

    public function bidDetail()
    {
        return $this->hasMany('App\Model\BidDetails', 'bid_id');
    }

    public function isUpdatable()
    {
        return $this->status == Constant::BID_STATUS_IN_PROGRESS;
    }
}
