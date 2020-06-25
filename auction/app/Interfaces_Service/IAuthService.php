<?php
namespace App\Interfaces_Service;
use Illuminate\Http\Request;

interface IAuthService
{
    public function register(Request $request);
    public function login(Request $request);
    public function changePassword(Request $request);
    public function forgotPassword(Request $request);
    public function getAuthenticatedUser();
    public function logout();
}
