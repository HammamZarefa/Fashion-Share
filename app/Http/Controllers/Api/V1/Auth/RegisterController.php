<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function __invoke(RegisterRequest $request)
    {
        try {
            $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
                'phone' => ['required']
            ]);
            $user = User::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password
            ]);
            $device = substr($request->userAgent() ?? '', 0, 255);
            return response()->json([
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken($device)->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
