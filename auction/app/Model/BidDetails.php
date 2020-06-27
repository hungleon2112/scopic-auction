<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BidDetails extends Model
{
    protected $table = 'bid_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bid_id', 'user_id' , 'price'
    ];

    public function bid()
    {
        return $this->belongsTo('App\Model\Bids', 'bid_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\Users', 'user_id');
    }

    public function scopeInUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
