<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'user logged out'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required'],
            'confirm_password' => ['required']
        ]);
        $user = auth()->user();
        $currentPassword = $request->current_password;
        $newPassword = $request->new_password;
        $confirmPassword = $request->confirm_password;

        if (!Hash::check($currentPassword, $user->password)) {
            return response()->json(['error' => 'Invalid current password'], 401);
        }

        if ($newPassword !== $confirmPassword) {
            return response()->json(['error' => 'Passwords do not match'], 400);
        }
        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent to your email'], 200)
            : response()->json(['error' => 'Unable to send password reset link'], 400);
    }
}
