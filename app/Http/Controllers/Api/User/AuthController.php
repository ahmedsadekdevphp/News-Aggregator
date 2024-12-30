<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $response = AuthService::login($request);
        return response()->json($response);
    }

    /**
     * Destroy an authenticated session.
     */
    public function logout()
    {
        $user = Auth::guard('api')->user();
        $user->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.', 'status' => Response::HTTP_OK]);
    }
}
