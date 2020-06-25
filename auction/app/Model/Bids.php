<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bids extends Model
{
    use SoftDeletes;

    protected $table = 'bids';
    protected $primaryKey = 'id';
    protected $fillable = [
        'item_id', 'status' , 'closed_date'
    ];


    public function bidDetail()
    {
        return $this->hasMany('App\Model\BidDetails', 'bid_id');
    }

}
