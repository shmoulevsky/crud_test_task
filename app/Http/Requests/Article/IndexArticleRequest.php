<?php

namespace App\Http\Requests\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexArticleRequest extends FormRequest
{

    public function rules()
    {
        return [
            'sort' => ['string', Rule::in(Article::getSortable())],
        ];
    }
}
