<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\api\Auth\MustVerifyEmail;

class EnsureApiEmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(key_exists('App\Http\Controllers\api\Auth\MustVerifyEmail', \class_uses($request->user('api')))){
            if(!$request->user('api')->hasVerifiedEmail()) {
                return response()->json('Your email has not yet been verified.', 422);
            }
        }
        return $next($request);
    }
}
