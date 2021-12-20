<?php

namespace App\Services\User;

use App\Entities\User\AuthDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function loginByEmail(AuthDTO $authDTO) : string
    {
        $user = User::where('email', $authDTO->email)->first();
        if (!$user || !Hash::check($authDTO->password, $user->password)){
            throw new \DomainException('Login or password invalid');
        }

        $user->tokens()->delete();

        return $user->createToken($authDTO->device_name)->plainTextToken;
    }
}
