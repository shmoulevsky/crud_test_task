<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected const PAGE_LIMIT = 10;
    protected const SORTABLE = [];

    public static function getPageLimit()
    {
        return static::PAGE_LIMIT;
    }

    public static function getSortable(): array
    {
        return static::SORTABLE;
    }

}
