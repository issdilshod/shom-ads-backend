<?php

namespace App\Services\Account;

use App\Http\Resources\Account\UserResource;
use App\Models\Account\User;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

class UserService extends Service{

    public function all()
    {
        $users = User::where('deleted_at', null)
                    ->orderBy('first_name', 'asc')
                    ->orderBy('last_name', 'asc')
                    ->paginate(Config::get('pagination.per_page'));

        return UserResource::collection($users);
    }

    public function get($userId)
    {
        $user = User::where('deleted_at', null)
                    ->where('id', $userId)
                    ->first();

        if ($user==null){
            return response()->json(['msg' => 'not found'], 404);
        }
        
        return new UserResource($user);
    }

    public function create($user)
    {
        $exist = $this->exist($user);
        if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $user = User::create($user);

        return new UserResource($user);
    }

    public function update($user, $userId)
    {
        $exist = $this->exist($user, $userId);
        if ($exist){ return response()->json(['msg'=> 'conflict'], 409); }

        $userOriginal = User::where('deleted_at', null)
                            ->where('id', $userId)
                            ->first();

        if ($userOriginal==null){
            return response()->json(['msg' => 'not found'], 404);
        }

        $userOriginal->update($user);
        
        return new UserResource($user);
    }

    public function delete($userId)
    {
        User::where('deleted_at', null)
            ->where('id', $userId)
            ->update(['deleted_at' => Carbon::now()]);
    }

    public function exist($user, $userId = '')
    {
        $user = User::where('deleted_at', null)
                    ->when(isset($user['username']), function($q) use($user){
                        $q->where('username', $user['username']);
                    })
                    ->when(isset($user['phone']), function($q) use($user){
                        $q->where('phone', $user['phone']);
                    })
                    ->when(isset($user['email']), function($q) use($user){
                        $q->where('email', $user['email']);
                    })
                    ->when($userId!='', function ($q) use($userId){
                        $q->where('id', '!=', $userId);
                    })
                    ->first();
        if ($user==null){
            return false;
        }
        return true;
    }

    public function validate($user)
    {
        $user = $user->validate([
            'role' => '',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => '',
            'phone' => '',
            'email' => ''
        ]);

        return $user;
    }

}