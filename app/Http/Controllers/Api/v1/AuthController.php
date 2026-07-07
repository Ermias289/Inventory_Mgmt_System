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

    public function __construct(AuthService $_authService)
    {
        $this->authService = $_authService;
    }

    public function register(RegisterRequest $request)
    {
        $data = $request -> validated();
        
        $result = $this->_authService->register($data);

        return response()->json($result);
    }

    public function login(LoginRequest $request)
    {

    }

    public function logout()
    {

    }

    public function refresh()
    {

    }

    public function me()
    {

    }


}
