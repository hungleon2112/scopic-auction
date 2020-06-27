<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces_Service\IAuthService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    protected $apiAuthService;

    public function __construct(IAuthService $apiAuthService)
    {
        $this->apiAuthService = $apiAuthService;
        $this->middleware('cors');
    }

    public function register(Request $request)
    {
        $response = $this->apiAuthService->register($request);
        return response()->json($response->content, $response->status);
    }

    public function login(Request $request)
    {
        $response = $this->apiAuthService->login($request);
        return response()->json($response->content, $response->status);
    }

    public function logout()
    {
        
    }

}
