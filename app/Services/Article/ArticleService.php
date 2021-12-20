<?php

namespace App\Services\Article;

use App\Entities\Article\ArticleCreateTDO;
use App\Entities\Article\ArticleUpdateTDO;
use App\Models\Article;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ArticleService
{
    public function create(ArticleCreateTDO $articleTDO) : Article
    {
        $article = new Article();
        DB::transaction(function() use ($articleTDO, $article){

            $article->title = $articleTDO->title;
            $article->text = $articleTDO->text;
            $article->is_active = $articleTDO->isActive;
            $article->save();

            $userIds = User::whereIn('id', $articleTDO->authorIds)->pluck('id')->toArray();
            $article->authors()->attach($userIds);

        });

        return $article;
    }

    public function update(ArticleUpdateTDO $articleTDO) : Article
    {
        $article = Article::findOrFail($articleTDO->id);

        DB::transaction(function() use ($articleTDO, $article){

            $article->title = $articleTDO->title ?? $article->title;
            $article->text = $articleTDO->text ?? $article->text;
            $article->is_active = $articleTDO->isActive ?? $article->is_active;
            $article->save();

            if(count($articleTDO->authorIds) >= 1){
                $userIds = User::whereIn('id', $articleTDO->authorIds)->pluck('id')->toArray();
                $article->authors()->sync($userIds);
            }

        });

        return $article;
    }

    public function delete(int $id) : void
    {
        $article = Article::findOrFail($id);
        $article->delete();
    }

    public function checkRights(User $user, $articleId, $action)
    {
        $article = Article::with('authors:id')
            ->select('id')
            ->where(['id' => $articleId])
            ->firstOrFail();

        if ($user->cannot( $action, $article)) {
            abort(403, "Only author perform the {$action} action");
        }
    }
}
