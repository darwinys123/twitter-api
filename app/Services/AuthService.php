<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthService
{
  public function register($request)
  {
    $user = User::create($request->all());

    return $user;
  }

  public function login($request)
  {
    if (!Auth::attempt($request->only('email', 'password'))) {
      return response()->json([
        'message' => 'Invalid Credentials'
      ], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('token')->plainTextToken;
    $cookie = cookie('jwt', $token, 60 * 24);

    return response()->json([
      'user' => $user
    ])->withCookie($cookie);
  }

  public function logout()
  {
    $cookie = Cookie::forget('jwt');

    return response()->json([
      'message' => 'Log out'
    ])->withCookie($cookie);
  }
}
