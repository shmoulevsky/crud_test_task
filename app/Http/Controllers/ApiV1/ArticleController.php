<?php

namespace App\Http\Controllers\ApiV1;

use App\Entities\Article\ArticleCreateTDO;
use App\Entities\Article\ArticleUpdateTDO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\IndexArticleRequest;
use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Resources\Article\ArticleCollection;
use App\Http\Resources\Article\ArticleResource;
use App\Models\Article;
use App\Repositories\Article\ArticleRepository;
use App\Services\Article\ArticleService;
use Illuminate\Http\Request;


class ArticleController extends Controller
{

    private ArticleService $articleService;
    private ArticleRepository $articleRepository;

    public function __construct(ArticleService $articleService, ArticleRepository $articleRepository)
    {
        $this->articleService = $articleService;
        $this->articleRepository = $articleRepository;
    }

    public function index(IndexArticleRequest $request)
    {
        $articles = $this->articleRepository
            ->withAuthors()
            ->filterByAuthorId($request->author_id)
            ->filterByAuthorName($request->author_name)
            ->orderBy($request->sort)
            ->paginate(Article::getPageLimit());

        return new ArticleCollection($articles);

    }

    public function store(StoreArticleRequest $request)
    {
        $articleTDO = new ArticleCreateTDO(
            $request->title,
            $request->text,
            $request->is_active,
            $request->author_id
        );

        if(!$request->user()->isAdmin()){
            $articleTDO->authorIds = [$request->user()->id];
        }

        $article = $this->articleService->create($articleTDO);
        return response()->json(['article' => $article], 201);
    }

    public function show($id)
    {
        $article = $this->articleRepository->findById($id);

        if(!$article){
            abort(404);
        }

        return new ArticleResource($article);
    }

    public function update(Request $request, $id)
    {

        $this->articleService->checkRights($request->user(), $id, 'update');
        $articleTDO = new ArticleUpdateTDO(
            $id,
            $request->title,
            $request->text,
            $request->is_active,
            $request->author_id,
        );

        $article = $this->articleService->update($articleTDO);
        return response()->json(['article' => $article], 200);
    }

    public function destroy(Request $request, $id)
    {
        $this->articleService->checkRights($request->user(), $id, 'delete');
        $this->articleService->delete($id);
        return response()->json(['status' => 'deleted'], 200);
    }
}
