<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class BaseRepository
{
    protected $builder;

    public function getBuilder(): Builder
    {
        return $this->builder;
    }

    public function paginate(int $pageLimit)
    {
        return $this->builder->paginate($pageLimit);
    }
}
