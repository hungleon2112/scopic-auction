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
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

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
            return $this->respondSuccessfulToController($item);
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
            return $this->respondSuccessfulToController($item);
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

    private function verifyItemDetailRequest($data)
    {
        $validate_bag = $this->validate($data, [
            'item_id' => 'required',
        ],
        [
            'required' => ':attribute_required',
        ]);
        if(count($validate_bag)){
            return $validate_bag;
        }
        return null;
    }

    private function bindBidDataforItem($item, $response_model)
    {
        $bid_collection = collect($item->bid ?? null)->only(['status', 'closed_date']);
        $bid_detail_collection = collect($item->bid->bidDetail ?? null);
        if($bid_collection->isNotEmpty())
        {
            $bid_collection["status"] = Constant::BID_STATUS_LABEL[$bid_collection["status"]];
            $bid_collection["closed_date"] = HelperService::formatDate($bid_collection["closed_date"]);
            $response_model["bid"] = $bid_collection;
        }
        if($bid_detail_collection->isNotEmpty())
        {
            if($bid_detail_collection->count() > 1)
            {
                $bid_detail_collection = $bid_detail_collection->sortByDesc('price');
            }
            foreach($bid_detail_collection as $bid)
            {
                $user_collection = collect($bid->user);
                $bid = collect($bid)->only(['price', 'created_at']);
                $bid["created_at"] = HelperService::formatDate($bid["created_at"]);
                $bid["user"] = $user_collection["name"];
                $response_model["bid_detail"][] = $bid;
            }
        }
        return $response_model;
    }

    public function itemDetail(Request $request)
    {
        try{
            $data = $request->all();
            //Validate Input
            $validate_bag = $this->verifyItemDetailRequest($data);
            if($validate_bag != null)
            {
                return $this->respondValidateErrorToController($validate_bag);
            }
            //Find Item
            $item = $this->mainRepository->find($data['item_id']);
            if($item)
            {
                $item->image = env('APP_URL') ."/" . $item->image;
                $response_model = [
                    'item' => collect($item)->only('name', 'image', 'desc')
                ];
                $response_model = $this->bindBidDataforItem($item, $response_model);
            }
            else
            {
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_CREDENTIALS);
            }
            return $this->respondSuccessfulToController([
                'data' => $response_model,
            ]);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    public function itemList()
    {
        try{
            $items = $this->mainRepository->all();
            $response_model= [];
            foreach($items as $item)
            {
                $item->image = env('APP_URL') ."/" . $item->image;
                $response_model_tmp = [
                    'item' => collect($item)->only('id', 'name', 'image', 'desc')
                ];
                $response_model_tmp = $this->bindBidDataforItem($item, $response_model_tmp);
                $response_model[] = $response_model_tmp;
            }
            return $this->respondSuccessfulToController([
                'data' => $response_model,
            ]);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }
}
