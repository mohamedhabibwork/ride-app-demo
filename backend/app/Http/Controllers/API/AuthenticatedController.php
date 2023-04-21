<?php

namespace App\Http\Controllers\API;

use App\Events\User\UserLoggedInEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Http\Request;

class AuthenticatedController extends Controller
{
    public function currentUser(Request $request)
    {
        return response()->json([
            'user' => $request->user()->loadMissing('driver'),
            'token' => $request->user()->currentAccessToken()
        ]);
    }
    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'min:10', 'max:20'],
            'password' => ['required', 'string'],
        ]);

        if ((!$user = User::with('driver')->firstWhere('phone', $request->get('phone'))) ||
            (!Hash::check($request->get('password'), $user->password))) {
            return response()->json([
                'message' => __('auth.failed'),
            ], 401);
        }

//        UserLoggedInEvent::dispatch($user);

        return response()->json([
            'message' => __('auth.login'),
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email:filter|max:50|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($validated);

        $token = $user->createToken(
            "{$request->get('email')}|{$request->getClientIp()}"
        )->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => __('auth.logout'),
        ]);
    }

    public function existsPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        return response()->json([
            'exists_phone' => User::with('driver')
                ->where('phone', $request->get('phone'))
                ->exists(),
            'phone' => $request->get('phone')
        ]);
    }

    public function login_verification(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'login_code' => 'required',
        ]);
        $user = User::with('driver')
            ->where('login_code', $request->get('login_code'))
            ->where('phone', $request->get('phone'))
            ->first();

        if (!$user) {
            return response()->json([
                'message' => __('auth.failed'),
            ], 401);
        }
//        $user->update([
//            'login_code' => null,
//        ]);
        $token = $user->createToken(
            "{$request->get('email')}|{$request->getClientIp()}"
        )?->plainTextToken;

        event(new Authenticated('api', $user));

        return response()->json([
            'user' => $user,
            'token' => $token ?? null,
        ]);
    }


}
