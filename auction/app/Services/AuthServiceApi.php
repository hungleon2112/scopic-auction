<?php

namespace App\Services;

use App\Abstracts\AEloquentRepository;
use App\Abstracts\AEloquentService;
use App\Interfaces_Service\IAuthService;
use App\Model\Constant;
use App\Traits\TraitsRespond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthServiceApi extends AEloquentService implements IAuthService
{
    use TraitsRespond;
    protected $userRepository;

    public function __construct(
        AEloquentRepository $userRepository
    )
    {
        $this->mainRepository = $userRepository;
    }

    private function verifyRegisterRequestInput($data)
    {
        $validate_bag = $this->validate($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|max:255',
        ],
        [
            'required' => ':attribute_required',
            'email' => ':attribute_invalid_format',
            'max' => ':attribute_exceed_length',
            'unique' => ':attribute_unique',
        ]
        );
        if(count($validate_bag)){
            return $validate_bag;
        }
        return null;
    }

    public function register(Request $request)
    {
        $data = $request->json()->all();
        $validate_bag = $this->verifyRegisterRequestInput($data);
        if($validate_bag != null)
        {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try
        {
            $data['password'] = Hash::make($data['password']);
            $user = $this->mainRepository->create($data);
            //SUCCESS
            if($user)
            {
                return $this->respondSuccessfulToController([
                    'data' => (object)
                        [
                            'message' => Constant::MESSAGE_OK
                        ]
                ]);
            }
        }
        catch(Exception $e)
        {
            return $this->respondInternalErrorToController($e);
        }
    }

    private function verifyLoginRequestInput($data)
    {
        $validate_bag = $this->validate($data, [
            'username' => 'required|string',
            'password' => 'required',
        ],
        [
            'required' => ':attribute_required',
        ]
        );
        if(count($validate_bag)){
            return $validate_bag;
        }
        return null;
    }

    public function login(Request $request)
    {
        $data = $request->json()->all();
        $validate_bag = $this->verifyLoginRequestInput($data);
        if($validate_bag != null)
        {
            return $this->respondValidateErrorToController($validate_bag);
        }
        try {
            $token = JWTAuth::attempt((array)$data);
            if (!$token ) {
                return $this->respondUnsuccessfulToController(Constant::MESSAGE_INVALID_CREDENTIALS);
            }
            $user = JWTAuth::setToken($token)->getPayload();
            return $this->respondSuccessfulToController([
                'data' => (object)
                    [
                        'token' => $token
                    ]
            ]);
        } catch (JWTException $e) {
            return $this->respondInternalErrorToController($e);
        }
    }

    public function getAuthenticatedUser()
    {
        // No need to implement because Vuejs will parse the token
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
