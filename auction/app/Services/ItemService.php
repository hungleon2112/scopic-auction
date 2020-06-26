<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IItemService;
use App\Interfaces_Repository\IBidRepository;
use App\Model\Constant;
use App\Traits\TraitsUpload;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Datetime;

class ItemService extends AEloquentService implements IItemService
{
    use TraitsUpload;
    use TraitsRespond;
    protected $itemRepository;

    public function __construct(
        AEloquentRepository $itemRepository,
        IBidRepository $bidRepository
    )
    {
        $this->mainRepository = $itemRepository;
        $this->bidRepository = $bidRepository;
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
            return $this->respondInternalErrorToController($credentials, $e);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validate_bag = $this->validate($data, [
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail)  use ($data, $id) {
                    if(
                        $this->mainRepository->getModel()
                            ->where('name', $data['name'])
                            ->where('id', '<>', $id)
                            ->first()
                    ){
                        $fail("Item {$value} is existed.");
                    }
                }
            ],
            'file' => 'mimes:jpeg,jpg,png'
        ]);
        if (count($validate_bag)) {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            DB::beginTransaction();
            $this->mainRepository->update($data, $id);
            $item = $this->find($id);

            if (isset($request->file))
            {
                $path = $this->uploadItemImage($request);
                $item->image = $path;
                $item->save();
            }
            DB::commit();
            return $this->respondSuccessfulToController($item, $data);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    public function bid(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->find($data["item_id"]);
            $data = $this->verifyBid($data);
            if ($data && $item && $item->canSetBid()) {
                $data["status"] = Constant::BID_STATUS_IN_PROGRESS;
                $this->bidRepository->create($data);
            }
            else
            {
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_INPUT);
            }
            return $this->respondSuccessfulToController($item, $data);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    public function bidUpdate(Request $request)
    {
        $data = $request->all();
        try {
            $bid = $this->bidRepository->find($data["id"]);
            $data = $this->verifyBid($data);
            if ($data && $bid && $bid->isUpdatable() && (strtotime($bid->closed_date) < strtotime($data["closed_date"])) ) {
                $bid->closed_date = $data["closed_date"];
                $bid->save();
            }
            else
            {
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_INPUT_UPDATE);
            }
            return $this->respondSuccessfulToController($bid, $data);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    private function verifyBid($data)
    {
        $validate_bag = $this->validate($data, [
            'closed_date' => 'required',
            'closed_time' => 'required',
            'item_id' => 'required'
        ]);
        if (count($validate_bag)) {
            return $this->respondValidateErrorToController($validate_bag);
        }
        $data["closed_date"] = $data["closed_date"]. " " .$data["closed_time"];
        if (DateTime::createFromFormat('Y-m-d H:i', $data["closed_date"]) !== FALSE)
        {
            return $data;
        }
        return false;
    }

}
