<?php

namespace App\Http\Controllers;

use App\Abstracts\AEloquentService;
use App\Model\Users;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $userService;

    public function __construct(AEloquentService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $response = $this->userService->register($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->status == Response::HTTP_INTERNAL_SERVER_ERROR ? $response->content : $response->content['error']) :
            redirect(route('users.index'))->with(['message' => 'Successfully create user.']);
    }

}
