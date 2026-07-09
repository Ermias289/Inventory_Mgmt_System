<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return [
            'success' => true,
            'message' => 'User registered successfully.',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ],
        ];
    }

    public function login(array $credentials)
    {
        if (!$token = auth()->attempt($credentials))
        {
            return throw new AuthenticationException('Invalid credentials.');
        }

        $user = auth()->user();

        $token = JWTAuth::fromUser($user);

        return [
            'success' => true,
            'message' => 'Login Successful.',
            'data' => [
                'user' => new UserResource($user),
                'token' => $token,
            ],
        ];

    }

    public function logout()
    {

    }

    public function refresh()
    {

    }

    public function me()
    {
        $user = auth()->user();

        if (!$user) {
            return throw new AuthenticationException('User not authenticated.');
        }

        return [
            'success' => true,
            'message' => 'User retrieved successfully.',
            'data' => [
                'user' => new UserResource($user),
            ],
        ];
    }
}