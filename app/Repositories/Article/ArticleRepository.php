<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;


class ArticleRepository extends BaseRepository
{

    public function __construct()
    {
        $this->builder = Article::query();
    }

    public function withAuthors() : self
    {
        $this->builder->with('authors');
        return $this;
    }

    public function filterByAuthorName(?string $authorName) : self
    {
        $this->builder->when($authorName, function($query) use ($authorName){
            $query->whereHas('authors', function ($subquery) use ($authorName){
                $subquery->where('users.name','like', '%'.$authorName.'%');
            });
        });

        return $this;
    }

    public function filterByAuthorId(?int $authorId) : self
    {
        $this->builder->when($authorId, function($query) use ($authorId){
            $query->whereHas('authors', function ($subquery) use ($authorId){
                $subquery->where('user_id', $authorId);
            });
        });

        return $this;
    }

    public function orderBy(?string $sortField) : self
    {
        $this->builder->when($sortField, function ($query) use ($sortField){
            $query->orderBy($sortField, 'asc');
        });
        return $this;
    }

    public function findById($id)
    {
        return Article::whereId($id)->with('authors:id,name')->first();
    }

}
