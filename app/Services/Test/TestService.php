<?php

namespace App\Services\Test;

use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestService
{
    private string $token;
    private const TEST_USER_COUNT = 2;
    private const TEST_ZERO_USER_COUNT = 1;
    private const TEST_ARTICLE_COUNT = 2;

    public function makeUser(
        string $role = '',
        string $email = 'test@test.ru',
        string $name = 'Test Name',
        string $deviceName = 'Test Device',
        string $password = 'pass123456',
    )
    {
        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name,
            'role' => $role ?? USER::getUserRole(),
        ]);

        $this->token = $user->createToken($deviceName)->plainTextToken;

        return $user;
    }


    public function getToken(): string
    {
        return $this->token;
    }

    public function makeUserArticle($user)
    {
        $article = Article::factory()->create();
        $user->articles()->attach([$article->id]);
    }

    public function makeArticles()
    {
        User::factory(self::TEST_USER_COUNT)
            ->has(Article::factory()->count(self::TEST_ARTICLE_COUNT))
            ->create();

        User::factory(self::TEST_ZERO_USER_COUNT)
            ->has(Article::factory()->count(0))
            ->create();

    }
}
