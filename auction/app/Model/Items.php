<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Items extends Model
{
    use SoftDeletes;

    protected $table = 'items';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'image' , 'desc'
    ];

    public function bid()
    {
        return $this->hasOne('App\Model\Bids', 'item_id');
    }

    public function isDeletable()
    {
        return $this->bid == null;
    }

    public function canSetBid()
    {
        return $this->bid == null;
    }

}
