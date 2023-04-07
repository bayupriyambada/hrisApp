<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLogin\{RegisterRequest, LoginRequest};
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credential = request(['email', 'password']);
            if (!auth()->attempt($credential)) {
                return ResponseFormatter::error('Unaunthorized', 401);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password)) {
                throw new Exception("Invalid Password");
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authentication successfully!');
        } catch (Exception) {
            return ResponseFormatter::error('Authentication Failed');
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            // Todo: Create User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Todo: Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Register successfully!');
        } catch (Exception $error) {
            return ResponseFormatter::error($error->getMessage());
        }
    }

    public function logout(Request $request)
    {
        // revoke Token
        $token = $request->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Logout Success');
    }
    public function fetchUser(Request $request)
    {
        // fetch user
        $fetchUser = $request->user();
        return ResponseFormatter::success($fetchUser, 'Get User Success');
    }
}
