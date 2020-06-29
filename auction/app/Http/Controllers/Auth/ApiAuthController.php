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
    /**
         * @SWG\Post(
         *     path="/api/v1/register",
         *     description="Register",
        *     @SWG\Parameter(
        *          name="body",
        *          in="body",
        *          required=true,
        *          @SWG\Schema(
        *              @SWG\Property(
        *                  property="name",
        *                  type="string"
        *              ),
        *              @SWG\Property(
        *                  property="email",
        *                  type="string"
        *              ),
        *              @SWG\Property(
        *                  property="username",
        *                  type="string"
        *              ),
        *              @SWG\Property(
        *                  property="password",
        *                  type="string"
        *              ),
        *          )
        *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="Request Success",
         *     ),
         *     @SWG\Response(
         *         response=400,
         *         description="Bad Request"
         *     ),
         *     @SWG\Response(
         *         response=500,
         *         description="Server Error"
         *     )
         * )
    */
    public function register(Request $request)
    {
        $response = $this->apiAuthService->register($request);
        return response()->json($response->content, $response->status);
    }

    /**
         * @SWG\Post(
         *     path="/api/v1/login",
         *     description="Login",
        *     @SWG\Parameter(
        *          name="body",
        *          in="body",
        *          required=true,
        *          @SWG\Schema(
        *              @SWG\Property(
        *                  property="username",
        *                  type="string"
        *              ),
        *              @SWG\Property(
        *                  property="password",
        *                  type="string"
        *              )
        *          )
        *     ),
         *     @SWG\Response(
         *         response=200,
         *         description="{'token' : '....'}",
         *     ),
         *     @SWG\Response(
         *         response=400,
         *         description="{'error' : 'Invalid Credentials'}"
         *     ),
         *     @SWG\Response(
         *         response=500,
         *         description="{'error' : 'could_not_create_token'}"
         *     )
         * )
    */
    public function login(Request $request)
    {
        $response = $this->apiAuthService->login($request);
        return response()->json($response->content, $response->status);
    }

    public function logout()
    {
        
    }

}
