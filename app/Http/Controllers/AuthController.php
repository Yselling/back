<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request) : JsonResponse
    {
        $messages = [
            'email.required' => __('lang.email.required'),
            'email.email' => __('lang.email.email'),
            'email.unique' => __('lang.email.unique'),
            'password.required' => __('lang.password.required'),
            'password.min' => __('lang.password.min'),
            'confirm_password.required' => __('lang.confirm_password.required'),
            'confirm_password.same' => __('lang.confirm_password.same'),
        ];

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create(
            [
                'email' => $request->input('email'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'gender_id' => $request->input('gender_id'),
                'role_id' => 2,
                'password' => Hash::make($request->input('password')),
                'email_verified_at' => now(),
            ]
        );

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
