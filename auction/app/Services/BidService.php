<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IBidService;
use App\Interfaces_Repository\IItemRepository;
use App\Model\Constant;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Datetime;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BidService extends AEloquentService implements IBidService
{
    use TraitsRespond;
    protected $bidRepository;
    protected $itemRepository;

    public function __construct(
        AEloquentRepository $bidRepository,
        IItemRepository $itemRepository
    )
    {
        $this->mainRepository = $bidRepository;
        $this->itemRepository = $itemRepository;
    }

    public function create(Request $request)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }
    public function createBidForItem(Request $request)
    {
        $data = $request->all();
        try {
            $item = $this->itemRepository->find($data["item_id"]);
            $data = $this->verifyBid($data);
            //Check if item is valid to set bid
            if ($data && $item && $item->canSetBid()) {
                $data["status"] = Constant::BID_STATUS_IN_PROGRESS;
                $this->mainRepository->create($data);
            }
            else
            {
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_INPUT);
            }
            return $this->respondSuccessfulToController($item);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    public function updateBidForItem(Request $request)
    {
        $data = $request->all();
        try {
            $bid = $this->find($data["id"]);
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
            return $this->respondSuccessfulToController($bid);
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

    public function listBiddingItem(){
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $bids = $this->mainRepository->listBiddingItem($user->id);
            $response_model = [];
            foreach($bids as $bid)
            {
                $bid->status = Constant::BID_STATUS_LABEL[$bid->status];
                $response_model[] = [
                    'bid' => $bid
                ];
            }
            return $this->respondSuccessfulToController([
                'data' => $response_model,
            ]);
        }
        catch(Exception $e)
        {
            return $this->respondInternalErrorToController($e);
        }
    }

    public function listAwardedItem(){
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $bids = $this->mainRepository->listAwardedItem($user->id);
            $response_model = [];
            foreach($bids as $bid)
            {
                $bid->status = Constant::BID_STATUS_LABEL[$bid->status];
                $response_model[] = [
                    'bid' => $bid
                ];
            }
            return $this->respondSuccessfulToController([
                'data' => $response_model,
            ]);
        }
        catch(Exception $e)
        {
            return $this->respondInternalErrorToController($e);
        }
    }

    private function verifyBidRequest($data)
    {
        $validate_bag = $this->validate($data, [
            'item_id' => 'required',
            'price' => 'required|numeric|not_in:0',
        ],
        [
            'required' => ':attribute_required',
            'numeric' => ':attribute_numeric',
            'not_in' => ':attribute_not_in',
        ]);
        if(count($validate_bag)){
            return false;
        }
        //Get bid from item
        $item = $this->itemRepository->find($data['item_id']);
        if(!$item)
            return false;

        $bid = $item->bid;
        //Check  bid valid (status)
        if(!$bid || !$bid->isUpdatable())
            return false;
            
        return $bid;
    }

    public function bid(Request $request)
    {
        try
        {
            $user = JWTAuth::parseToken()->authenticate();
            $data = $request->json()->all();

            //Check valid request (for user who try to cheat the request)
            $bid = $this->verifyBidRequest($data);
            if(!$bid)
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_INPUT_GENERAL);

            //Check bid value valid
            $bid_details = collect($bid->bidDetail)->last();
            if($bid_details && $data['price'] <= $bid_details->price)
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_PRICE_INVALID);

            //Check  bid timing valid in case the schedule checking deadline not run or not finish yet
            if(strtotime($bid->closed_date) < strtotime(date("Y/m/d H:i")))
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_TIME_INVALID);

            //Bid
            if($this->mainRepository->bid($bid->id, $user->id, $data['price']))
            {
                //TODO: Dispatch Job to send email for other user have bid this item

                return $this->respondSuccessfulToController([
                    'data' => (object)
                        [
                            'message' => Constant::MESSAGE_OK
                        ]
                ]);
            }
                
            return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_INPUT_GENERAL);
        }
        catch(Exception $e)
        {
            return $this->respondInternalErrorToController($e);
        }
    }
}
