<?php

namespace App\Http\Middleware;

use App\Models\Account\AccessToken;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class BearerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $bearerToken = $request->bearerToken();

        $accessToken = AccessToken::where('deleted_at', null)
                            ->where('token', $bearerToken)
                            ->where('expired_at', '>', Carbon::now()->toDateTimeString())
                            ->first();

        if ($accessToken==null){
            return response()->json(['msg' => 'not auth'], 401);
        }

        $request->merge(['current_user_id' => $accessToken->user_id]);

        return $next($request);
    }
}
