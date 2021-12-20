<?php

namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;

class AuthEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required', 'email:rfc',
                function ($attribute, $value, $fail) {
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail($attribute . ' is invalid.');
                    }
                }],
            'password' => ['required', 'string']
        ];
    }
}
