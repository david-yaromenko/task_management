<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{

    public function __construct(protected AuthRepository $authRepository) {}

    public function register(array $data): User
    {

        return $this->authRepository->register($data);
    }

    public function login(array $data): array
    {

        $user = $this->authRepository->login($data);

        $token = JWTAuth::fromUser($user);

        return [

            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role->name
            ]
        ];
    }
}
