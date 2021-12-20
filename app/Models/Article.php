<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends BaseModel
{
    use HasFactory;

    protected const SORTABLE = ['title', 'created_at', 'updated_at'];

    public function authors()
    {
        return $this->belongsToMany(User::class);
    }

}
