<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    /**
     * Retrieve a listing of articles.
     */
    public function index(Request $request)
    {
        $service = new ArticleService(auth()->user(), $request);
        $articles = $service->getArticlesForUser();

        // Send response
        return ArticleResource::collection($articles);
    }

    /**
     * Retrieve the article.
     */
    public function show(Article $article)
    {
        return ArticleResource::make($article);
    }
}
