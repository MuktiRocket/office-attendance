<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function userLogin(UserLoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = $request->user();
            if($user->active_status == 1){
                $data = [
                    'user' => new UserResource($user),
                    'access_token' => $user->createToken($user->email)->accessToken
                ];
                return $this->respond('Login Successful', Response::HTTP_OK, $data);
            }
            return $this->respond('Your profile is deactivated', Response::HTTP_FORBIDDEN);
        }

        return $this->respond('User not found', Response::HTTP_UNAUTHORIZED);
    }

    public function userLogout(Request $request)
    {
        $request->user()->token()->revoke();
        $data = [
            'logout' => 'LOGOUT DONE'
        ];
        return $this->respond('User successfully logged out', Response::HTTP_OK, $data);
    }
}
