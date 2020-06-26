<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IAuthService;
use App\Model\Constant;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        try
        {
            $credentials = [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'username' => 'admin',
                'role' => Constant::ROLE_ADMIN,
                'password' => Hash::make('admin')
            ];
            $user = $this->mainRepository->create($credentials);
            return $this->respondSuccessfulToController($credentials);
        }catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    /**
     * @param Request $request
     * @return BasicResponseModel
     */
    public function login(Request $request)
    {
        // get credentials from request
        $credentials = $request->only('username', 'password');

        $validate_bag = $this->validate($credentials, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if (count($validate_bag)) {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            if (auth('web')->attempt($credentials)) {
                if(auth('web')->user()->isAdmin()){
                    return $this->respondSuccessfulToController($credentials['username']);
                }
                auth('web')->logout();
            }
            return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_CREDENTIALS);
        } catch (\Exception $e) {
            return $this->respondInternalErrorToController($e);
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
    public function create(Request $request){
        // Implement create() method.
    }
    public function update(Request $request, $id){
        // Implement update() method.
    }
}
