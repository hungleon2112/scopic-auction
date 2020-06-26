<?php

namespace App\Http\Controllers;

use App\Abstracts\AEloquentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Model\Constant;
use Symfony\Component\HttpFoundation\Response;


use App\Model\Bids;
use Jobs\SendEmailToWinner;


class ItemController extends Controller
{
    protected $itemService;

    public function __construct(AEloquentService $itemService)
    {
        $this->itemService = $itemService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {


        $deadline_bid_id_arr = [];
        $deadline_bid_obj_arr = [];
        // Get all In Progress Bid
        $list_bids = Bids::where('status', Constant::BID_STATUS_IN_PROGRESS)->get();
        //Compare Closed Date Time and Current Date Time
        foreach($list_bids as $bid)
        {
            if(strtotime($bid->closed_date) <= strtotime(date("Y/m/d H:i")) )
            {
                //Store Array of bid ID for mass updating, avoid call many times to DB
                $deadline_bid_id_arr[] = $bid->id;
                //Store bid Object for sending email
                $deadline_bid_obj_arr[] = $bid;
            }
        }

        //Change Bid Status to Completed
        Bids::whereIn('id', $deadline_bid_id_arr)->update(['status' => Constant::BID_STATUS_IN_COMPLETED]);

        //Send Email to winner
        //To avoid this current schedule have not finish yet (sending email takes time about 1-2s) while another schedule run, we push to the job queue
        foreach($deadline_bid_obj_arr as $bid)
        {
            //Dispatch Job Queue
            SendEmailToWinner::dispatch($bid)->delay(now()->addSeconds(5));
        }










        return view('admin.ItemsIndexPage', [
            'items' => $this->itemService->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('admin.ItemsCreatePage');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $response = $this->itemService->create($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully create item']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        // TODO: implement this function later.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function edit($id)
    {
        $item = $this->itemService->find($id);
        return view('admin.ItemsEditPage', compact('item', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $response = $this->itemService->update($request, $id);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully update item']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $response = $this->itemService->delete($id);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully delete item']);
    }

    /**
     * Bid the specified resource.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function createBidForItem(Request $request)
    {
        $response = $this->itemService->createBidForItem($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully bid item']);
    }

    public function updateBidForItem(Request $request)
    {
        $response = $this->itemService->updateBidForItem($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully update bid for item']);
    }

}
