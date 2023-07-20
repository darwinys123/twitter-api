<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(UserRequest $request, AuthService $authService)
    {
        return $authService->register($request);
    } //

    public function login(Request $request, AuthService $authService)
    {
        return $authService->login($request);
    } //

    public function logout(AuthService $authService)
    {
        return $authService->logout();
    } //
}
