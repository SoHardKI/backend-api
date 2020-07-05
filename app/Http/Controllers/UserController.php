<?php

namespace App\Http\Controllers;

use App\User;
use DateTimeImmutable;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response
     */
    public function registration(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'full_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/',
                'confirm-password' => 'required|same:password',
                'phone' => 'required|unique:users,phone|min:12|max:12|regex:/(\+7)[0-9]{10}$/'
            ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors());
        } else {
            try {
                User::create($request->input());
                $message = 'User created successfully!';
            } catch (\Exception $exception) {
                $message = $exception->getMessage();
            }

            return new Response($message, 200, ['Content-Type' => 'application/json']);
        }
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function authorization(Request $request, User $user)
    {
        $now = new DateTimeImmutable();
        $key = env('AUTH_TOKEN');
        $payload = array(
            "sub" => $user->id,
            "iat" => $now->getTimestamp(),
            "nbf" => $now->getTimestamp(),
            "exp" => $now->modify('+1 minute')->getTimestamp()
        );

        $jwt = JWT::encode($payload, $key);

        return \response()->json(['token' => $jwt]);
    }
}
