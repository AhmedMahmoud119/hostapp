<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHeaderEvent
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->event == 'client.login') {
            if ( ! isset($_SERVER['HTTP_AUTHORIZATION'])) {
                return response()->json([
                    'error' => 'Please Provide api key & secret',
                ], 403);
            }


            $auth = $_SERVER['HTTP_AUTHORIZATION'];
            $auth = explode(' ', $auth ? $auth : null);

            $token = explode(':', base64_decode($auth[1] ? $auth[1] : null));

            $api_key = $token[0] ? $token[0] : null;
            $api_secret = $token[1] ? $token[1] : null;

            if ( ! $api_key || ! $api_secret) {
                return response()->json([
                    'error' => 'Please Provide api key & secret',
                ], 403);
            }

            request()->api_key = $api_key;
            request()->api_secret = $api_secret;

            return $next($request);
        }else{
            $auth = $_SERVER['HTTP_AUTHORIZATION'];
            $auth = explode(' ', $auth ? $auth : null);

            if(isset($auth[1])){

                $user = User::where('token',$auth[1])->first();

                if($user){
                    Auth::logi0nUsingId($user->id);
                }else{
                    return response()->json([
                        'error' => 'Please Provide Valid Token',
                    ], 403);
                }

            }else{
                return response()->json([
                    'error' => 'Please Provide Token',
                ], 403);
            }



            return $next($request);
        }

    }

}
