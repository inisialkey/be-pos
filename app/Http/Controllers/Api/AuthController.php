<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $request->validate($rules);

        /// cek apakah email dan password valid sesuai dengan di database
        $credentials = $request->only(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('authToken', ['*'], Carbon::now()->addDays(1))->plainTextToken;

        return response()->json([
            'message' => 'Login success',
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages(), Response::HTTP_UNPROCESSABLE_ENTITY
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('authToken', ['*'], Carbon::now()->addHours(1))->plainTextToken;

        return response()->json([
            'message' => 'Register success',
            'user' => $user,
            'token_type' => 'Bearer',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return response()->json([
            'token' => $token . ' Token Revoked',
            'user' => $request->user(),
            'message' => 'Logout success'
        ], 200);
    }

    public function fetch(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }
}
