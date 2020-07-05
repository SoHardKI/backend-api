<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;
use Illuminate\Http\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (isset($request->email) && !is_null($request->email) && isset($request->password) && !is_null($request->password)) {
            $user = \App\User::where(['email' => $request->email])->where(['password' => $request->password])->first();

            if ($user) {
                return $next($request, $user);
            } else {
                return new Response('Incorrect email or password!', 401, ['Content-Type' => 'application/json']);
            }
        } else {
            return new Response('Bad credentials!', 401, ['Content-Type' => 'application/json']);
        }

    }
}
