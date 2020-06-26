<?php

namespace App\Model;
use App\Model\Constant;
use App\Model\Items;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model
{
    protected $table = 'bids';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id', 'status' , 'closed_date'
    ];

    public function item()
    {
        return $this->belongsTo(Items::class, 'item_id');
    }

    public function bidDetail()
    {
        return $this->hasMany('App\Model\BidDetails', 'bid_id');
    }

    public function isUpdatable()
    {
        return $this->status == Constant::BID_STATUS_IN_PROGRESS;
    }
}
