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

class AdminAuthController extends Controller
{

    protected $adminAuthService;

    /**
     * AdminAuthController constructor.
     * @param IAuthService $adminAuthService
     */
    public function __construct(IAuthService $adminAuthService)
    {
        $this->adminAuthService = $adminAuthService;
    }

    /**
     * Show login page to user
     * @return Factory|View
     */
    public function getLogin()
    {
        return view('admin.LoginPage');
    }

    /**
     * Process login and redirect user to url
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function login(Request $request)
    {
        $response = $this->adminAuthService->login($request);
        return $response->status != Response::HTTP_OK ?
            redirect()->back()->withInput()->withErrors($response->content) :
            redirect('/')->with(['message' => 'Successfully logged in']);
    }

    /**
     * Log admin out and redirect to login page
     * @return RedirectResponse|Redirector
     */
    public function logout()
    {
        auth('web')->logout();
        return redirect('/login')->with(['message' => 'Successfully logged out']);
    }

}
