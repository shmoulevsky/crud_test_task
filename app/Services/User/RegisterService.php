<?php

namespace App\Services\User;

use App\Entities\User\RegisterDTO;
use App\Models\User;
use function bcrypt;

class RegisterService
{
    public function registerByEmail(RegisterDTO $registerDTO) : string
    {
        $user = new User();
        $user->name = $registerDTO->name;
        $user->email = $registerDTO->email;
        $user->password = $this->generatePasswordHash($registerDTO->password);
        $user->role = USER::getUserRole();
        $user->save();

        return $user->createToken($registerDTO->device_name)->plainTextToken;
    }

    public function generatePasswordHash($password) : string
    {
        return bcrypt($password);
    }

}
