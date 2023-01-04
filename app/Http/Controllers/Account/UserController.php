<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Services\Account\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
       
    public function index(Request $request)
    {
        // permission

        $users = $this->userService->all();
        
        return $users;
    }

    public function show(Request $request, $userId)
    {
        // permission

        $user = $this->userService->get($userId);

        return $user;
    }

    public function store(Request $request)
    {
        // permission

        $userValidated = $this->userService->validate($request);

        $user = $this->userService->create($userValidated);

        return $user;
    }

    public function update(Request $request, $userId)
    {
        // permission

        $userValidated = $this->userService->validate($request);

        $user = $this->userService->update($userValidated, $userId);

        return $user;
    }

    public function destroy(Request $request, $userId)
    {
        // permission

        $this->userService->delete($userId);

        return response()->json(['msg' => 'success'], 200);
    }

}
