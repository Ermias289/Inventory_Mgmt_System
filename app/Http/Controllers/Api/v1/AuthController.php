<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request -> validated();
        
        $result = $this->authService->register($data);

        return response()->json($result, 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request -> validated();

        $result = $this->authService->login($credentials);

        if (!$result) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials.'
                ], 401);
        }

        return response()->json($result);
    }

    public function logout()
    {
        $result = $this->authService->logout();

        return response()->json($result);
    }

    public function refresh()
    {
        $result = $this->authService->refresh();

        return response()->json($result);
    }

    public function me()
    {
        $result = $this->authService->me();

        return response()->json($result);
    }


}
