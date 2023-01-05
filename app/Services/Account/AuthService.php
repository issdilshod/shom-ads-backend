<?php

namespace App\Services\Account;

use App\Http\Resources\Account\AccessTokenResource;
use App\Models\Account\AccessToken;
use App\Models\Account\User;
use App\Services\Helpers\UserDetectService;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class AuthService extends Service{

    public function signin($auth)
    {
        $user = User::where('deleted_at', null)
                    ->where('username', $auth['username'])
                    ->where('password', $auth['password'])
                    ->first(['id']);
        
        if ($user==null){
            return response()->json(['msg' => 'invalid'], 404);
        }

        $accessToken = AccessToken::create([
            'user_id' => $user->id,
            'token' => Str::random(Config::get('auth.tokens.length')),
            'ip' => UserDetectService::ip(),
            'device' => UserDetectService::device_full(),
            'expired_at' => Carbon::now()->addDays(Config::get('auth.tokens.expired_day')),
        ]);

        return new AccessTokenResource($accessToken);
    }

    public function signup()
    {
        //
    }

    public function validate($auth)
    {
        $auth = $auth->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        return $auth;
    }

}