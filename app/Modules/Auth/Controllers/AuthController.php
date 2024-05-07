<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Requests\AuthStoreRequest;
use Defrindr\Crudify\Exceptions\UnauthenticatedHttpException;
use Defrindr\Crudify\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     */
    public function login(AuthStoreRequest $request)
    {
        $credentials = request(['email', 'password']);
        if (! Auth::attempt($credentials)) {
            throw new UnauthenticatedHttpException();
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;

        return ResponseHelper::successWithData([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return ResponseHelper::successWithData($request->user());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return ResponseHelper::successWithData(null, 'Successfully logged out');
    }
}
