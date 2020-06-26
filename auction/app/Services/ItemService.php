<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IItemService;
use App\Interfaces_Repository\IBidRepository;
use App\Model\Constant;
use App\Services\HelperService;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Datetime;

class ItemService extends AEloquentService implements IItemService
{
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
        //Validate Request Input
        $data = $request->all();
        $validate_bag = $this->verifyItemInput($data);
        if( $validate_bag != null)
        {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            DB::beginTransaction();
            //Create New Item
            $item = $this->mainRepository->create($data);
            //Upload Image to public folder then update item with image path
            $this->saveItemImage($request, $item);
            DB::commit();
            return $this->respondSuccessfulToController($item, $data);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($data, $e);
        }
    }

    public function update(Request $request, $id)
    {
        //Validate Request Input
        $data = $request->all();
        $validate_bag = $this->verifyItemInput($data, $id);
        if($validate_bag != null)
        {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            DB::beginTransaction();
            //Update Item (Name, Desc)
            $this->mainRepository->update($data, $id);
            $item = $this->find($id);
            //Update Image path for item
            $this->saveItemImage($request, $item);
            DB::commit();
            return $this->respondSuccessfulToController($item, $data);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    private function verifyItemInput($data, $id= null)
    {
        $validate_bag = $this->validate($data, [
            'name' => [
                'required',
                'max:255',
                //Make sure No duplicate item name except the current id
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
            return $validate_bag;
        }
        return null;
    }

    private function saveItemImage($request, $item)
    {
        if (isset($request->file))
        {
            $path = HelperService::uploadItemImage($request);
            $item->image = $path;
            $item->save();
        }
    }

    public function createBidForItem(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->find($data["item_id"]);
            $data = $this->verifyBid($data);
            //Check if item is valid to set bid
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

    public function updateBidForItem(Request $request)
    {
        $data = $request->all();
        try {
            $bid = $this->bidRepository->find($data["id"]);
            $data = $this->verifyBid($data);
            //Check if bid is valid to update (new closed date have to greater than current closed date, bid status must be In Progress)
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
        //Validate Request Input and return data
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
