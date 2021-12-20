<?php

namespace App\Http\Requests\Article;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['string', 'max:255'],
            'author_id' => [Rule::exists(User::class, 'id')],
        ];
    }
}
