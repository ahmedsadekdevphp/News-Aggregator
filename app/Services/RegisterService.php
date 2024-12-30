<?php

namespace App\Services;

use Illuminate\Http\Response;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterService
{
    public static function createUser($request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return
            [
                'status' => Response::HTTP_CREATED,
                'message'=>trans('user.registerUser')
            ]
        ;
    }
}
