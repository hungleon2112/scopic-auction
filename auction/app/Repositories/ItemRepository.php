<?php

namespace App\Repositories;

use App\Abstracts\AEloquentRepository;
use App\Interfaces_Repository\IItemRepository;
use App\Model\Items;

class ItemRepository extends AEloquentRepository implements IItemRepository
{
// model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(
        Items $model
    )
    {
        $this->model = $model;
    }

    public function getModel(): Items
    {
        return $this->model;
    }

    public function create($data){
        $user = $this->model->create($data);
        return $user;
    }

}
