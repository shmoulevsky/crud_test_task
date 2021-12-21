<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)
            ->has(Article::factory()->count(3))
            ->create();

        User::factory(5)
            ->has(Article::factory()->count(0))
            ->create();


    }
}
