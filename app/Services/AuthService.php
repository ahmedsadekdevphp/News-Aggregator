<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * Handle an incoming authentication request.
     */
    public static function login($request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return ['message' => trans('validation.unauthorized'), 'status' => Response::HTTP_UNAUTHORIZED];
        }
        $user = Auth::user();
        $token = $user->createToken('authToken')->plainTextToken;
        return ['token' => $token, 'status' => Response::HTTP_OK];
    }
}
