<?php

namespace App\Entities\User;

class RegisterDTO
{
    public string $name;
    public string $email;
    public string $password;
    public string $device_name;

    public function __construct(string $name, string $email, string $password, string $device_name)
    {

        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->device_name = $device_name;
    }
}
