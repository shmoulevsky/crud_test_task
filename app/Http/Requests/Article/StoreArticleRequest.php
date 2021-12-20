<?php

namespace App\Http\Requests\Article;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'text' => ['required'],
            'author_id' => ['required', Rule::exists(User::class, 'id')],
        ];
    }
}
