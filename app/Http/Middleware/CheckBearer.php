<?php

namespace App\Http\Middleware;

use Closure;
use DateTimeImmutable;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CheckBearer
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
        $header = $request->header('Authorization');

        if (Str::startsWith($header, 'Bearer ')) {
            $token = Str::substr($header, 7);

            if (!empty($token)) {
                try {
                    $decoded = JWT::decode($token, env('AUTH_TOKEN'), array('HS256'));
                } catch (ExpiredException $exception) {
                    return new Response($exception->getMessage() . '! Need authorization!', 403, ['Content-Type' => 'application/json']);
                }

                return $next($request);
            }
        }


        return new Response('Forbidden', 403, ['Content-Type' => 'application/json']);
    }
}
