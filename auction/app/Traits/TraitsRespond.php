<?php namespace App\Traits;

use App\DTO\BasicResponseModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Arr;

trait TraitsRespond
{
    protected $authRepository;

    public function validate($data, $rule, $messages = [])
    {
        $validator = Validator::make($data, $rule, $messages);
        if ($validator->fails()) {
            $data['error'] = Arr::flatten($validator->errors()->messages());
        }
        return $validator->errors();
    }

    public function respondSuccessfulToController($successful_model)
    {
        return new BasicResponseModel(
            $successful_model,
            Response::HTTP_OK
        );
    }

    public function respondUnsuccessfulToController($message = '')
    {
        return new BasicResponseModel(
            new MessageBag(['error' => $message]),
            Response::HTTP_BAD_REQUEST
        );
    }

    public function respondInternalErrorToController($e)
    {
        return new BasicResponseModel(
            new MessageBag(['error' => $e->getMessage()]),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    public function respondValidateErrorToController($validate_bag)
    {
        return new BasicResponseModel(
            [
                'error' => Arr::flatten($validate_bag->messages())
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
