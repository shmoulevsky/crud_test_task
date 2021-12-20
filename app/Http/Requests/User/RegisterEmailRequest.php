<?php

namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

class RegisterEmailRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'device_name' => ['required', 'string']
        ];
    }
}
