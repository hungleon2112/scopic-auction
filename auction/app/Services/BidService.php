<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IItemService;
use App\Model\Constant;
use App\Traits\TraitsUpload;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemService extends AEloquentService implements IItemService
{
    use TraitsUpload;
    use TraitsRespond;
    protected $itemRepository;

    public function __construct(
        AEloquentRepository $itemRepository
    )
    {
        $this->mainRepository = $itemRepository;
    }

    public function create(Request $request)
    {
        $credentials = $request->all();
        $validate_bag = $this->validate($credentials, [
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail)  use ($credentials) {
                    if(
                        $this->mainRepository->getModel()
                            ->where('name', $credentials['name'])
                            ->first()
                    ){
                        $fail("Item {$value} is existed.");
                    }
                }
            ],
            'file' => 'required|mimes:jpeg,jpg,png'
        ]);
        if (count($validate_bag)) {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            DB::beginTransaction();
            $item = $this->mainRepository->create($credentials);
            $path = $this->uploadItemImage($request);
            $item->image = $path;
            $item->save();
            DB::commit();
            return $this->respondSuccessfulToController($item, $credentials);
        } catch (\Exception $e) {
            print_r($e->getMessage());
            die();
            return $this->respondInternalErrorToController($credentials, $e);
        }
    }

    public function update(Request $request, $id)
    {
        
    }
}
