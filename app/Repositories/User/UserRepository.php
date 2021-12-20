<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        $this->builder = User::query();
    }

    public function withCount(): self
    {
        $this->builder->withCount('articles');
        return $this;
    }

    public function filterByArticlesCount(?string $count): self
    {
        $this->builder->when($count, function ($query) use ($count) {
            $query->has('articles', '>=', $count);
        });
        return $this;
    }

    public function sortByArticlesCount(?string $count): self
    {
        $this->builder->when($count, function ($query) use ($count) {
            $query->orderBy('articles_count', $count);
        });
        return $this;
    }


}
