<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces\IAuthService;
use App\Model\Constant;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;

class AuthServiceAdmin extends AEloquentService implements IAuthService
{
    use TraitsRespond;
    protected $userRepository;

    public function __construct(
        AEloquentRepository $userRepository
    )
    {
        $this->mainRepository = $userRepository;
    }

    public function register(Request $request)
    {
        // Ignore this function because admin can not register and only can create by super admin.
    }

    /**
     * @param Request $request
     * @return BasicResponseModel
     */
    public function login(Request $request)
    {
        // get credentials from request
        $credentials = $request->only('email', 'password');

        $validate_bag = $this->validate($credentials, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (count($validate_bag)) {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            if (auth('web')->attempt($credentials)) {
                if(auth('web')->user()->isAdmin()){
                    return $this->respondSuccessfulToController('logged in', $credentials['email']);
                }
                auth('web')->logout();
            }
            return $this->respondUnsuccessfulToController($credentials['email'], Constant::MESSAGE_INVALID_CREDENTIALS);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($credentials['email'], $e);
        }
    }

    public function getAuthenticatedUser()
    {
        // Implement getAuthenticatedUser() method.
    }
    public function changePassword(Request $request){
        // Implement changePassword() method.
    }
    public function forgotPassword(Request $request){
        // Implement forgotPassword() method.
    }
    public function logout(){
        // Implement logout() method.
    }
}
