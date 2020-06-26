<?php

namespace App\Http\Controllers;

use App\Abstracts\AEloquentService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

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
            redirect()->back()->withInput()->withErrors($response->status == Response::HTTP_INTERNAL_SERVER_ERROR ? $response->content : $response->content['error']) :
            redirect(route('items.index'))->with(['message' => 'Successfully create item.']);
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
            redirect()->back()->withInput()->withErrors($response->status == Response::HTTP_INTERNAL_SERVER_ERROR ? $response->content : $response->content['error']) :
            redirect()->back()->with(['message' => 'Successfully update item.']);
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
            redirect()->back()->withInput()->withErrors($response->status == Response::HTTP_INTERNAL_SERVER_ERROR ? $response->content : $response->content['error']) :
            redirect(route('items.index'))->with(['message' => 'Successfully delete item.']);
    }

    /**
     * Bid the specified resource.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function bid(Request $request)
    {
        $response = $this->itemService->bid($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully bid item']);
    }

    public function bidUpdate(Request $request)
    {
        $response = $this->itemService->bidUpdate($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect()->back()->with(['message' => 'Successfully update bid for item']);
    }

}
