<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BidDetails extends Model
{
    use SoftDeletes;

    protected $table = 'bid_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bid_id', 'user_id' , 'price'
    ];

}
