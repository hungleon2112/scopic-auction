<?php
namespace App\Repositories;

use App\Abstracts\AEloquentRepository;
use App\Interfaces_Repository\IBidRepository;
use App\Model\Bids;

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


}
