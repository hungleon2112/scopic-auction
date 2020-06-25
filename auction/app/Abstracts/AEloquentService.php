<?php

namespace App\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;

abstract class AEloquentService
{
    protected $mainRepository;

    abstract public function create(Request $request);

    abstract public function update(Request $request, $id);

    function all()
    {
        return $this->mainRepository->all();
    }

    function delete($id){
        $this->mainRepository->delete($id);
    }

    function find($id)
    {
        return $this->mainRepository->find($id);
    }
}
