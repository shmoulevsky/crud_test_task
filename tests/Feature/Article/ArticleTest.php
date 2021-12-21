<?php

namespace Tests\Feature\Article;

use App\Models\Article;
use App\Models\User;
use App\Services\Test\TestService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;


class ArticleTest extends TestCase
{
    use DatabaseTransactions;

    private $user;


    public function setUp(): void
    {
        parent::setUp();
        $testService = new TestService();
        $this->user = $testService->makeUser('user');
        $testService->makeArticles();

    }

    public function test_index()
    {

        $response = $this->actingAs($this->user)
            ->json(
                'GET',
                '/api/v1/articles',
            );

        $response->assertStatus(200);
    }

    public function test_store()
    {

        $response = $this->actingAs($this->user)
            ->json(
                'POST',
                '/api/v1/articles',
                [
                    "title" => "Test title",
                    "text" => "Text here test",
                    "is_active" => true,
                    "author_id" => [$this->user->id]
                ]
            );

        $response->assertStatus(201);
    }

    public function test_update()
    {
        $testService = new TestService();
        $testService->makeUserArticle($this->user);

        $id = $this->user->articles()->first()->id;

        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                '/api/v1/articles/'.$id,
                [
                    "title" => "Update test title",
                    "text" => "New here test",
                    "is_active" => true,
                    "author_id" => [$this->user->id]
                ]
            );

        $response->assertStatus(200);
    }

    public function test_update_forbidden()
    {
        $id = Article::latest()->first()->id;
        $response = $this->actingAs($this->user)
            ->json(
                'PATCH',
                '/api/v1/articles/'.$id,
                [
                    "title" => "Update test title",
                    "text" => "New here test",
                    "is_active" => true,
                    "author_id" => [$this->user->id]
                ]
            );

        $response->assertStatus(403);
    }

    public function test_delete()
    {
        $testService = new TestService();
        $testService->makeUserArticle($this->user);
        $id = $this->user->articles()->first()->id;

        $response = $this->actingAs($this->user)
            ->json(
                'DELETE',
                '/api/v1/articles/'.$id,
                []
            );

        $response->assertStatus(200);
    }

    public function test_delete_forbidden()
    {
        $id = Article::latest()->first()->id;

        $response = $this->actingAs($this->user)
            ->json(
                'DELETE',
                '/api/v1/articles/'.$id,
                []
            );

        $response->assertStatus(403);
    }

    public function test_update_admin()
    {
        $testService = new TestService();
        $id = Article::latest()->first()->id;
        $admin = $testService->makeUser('admin', 'admin@test.ru');

        $response = $this->actingAs($admin)
            ->json(
                'PATCH',
                '/api/v1/articles/'.$id,
                [
                    "title" => "Update test title",
                    "text" => "New here test",
                    "is_active" => true,
                    "author_id" => [$this->user->id]
                ]
            );

        $response->assertStatus(200);
    }

}
