<?php
namespace App\Repositories;

use App\Abstracts\AEloquentRepository;
use App\Model\Users;

class UserRepository extends AEloquentRepository
{
// model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(
        Users $model
    )
    {
        $this->model = $model;
    }

    public function create($data){
        $user = $this->model->create($data);
        return $user;
    }


}
