<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\Account\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }
    
    public function signin(Request $request)
    {
        $auth = $this->authService->validate($request);

        $accessToken = $this->authService->signin($auth);

        return $accessToken;
    }

    public function signup(Request $request)
    {
        //
    }

    public function isauth(Request $request)
    {
        //
    }

}
