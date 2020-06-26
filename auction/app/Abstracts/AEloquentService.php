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

    function delete($id)
    {
        $credentials = ['id' => $id];
        $model = $this->find($id);
        if(!$model->isDeletable()){
            return $this->respondValidateErrorToController(
                new MessageBag([
                    'error' => Response::HTTP_BAD_REQUEST.'. Bad request!'
                ])
            );
        }
        try {
            $this->mainRepository->delete($id);
            return $this->respondSuccessfulToController($credentials);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    function find($id)
    {
        return $this->mainRepository->find($id);
    }
}
