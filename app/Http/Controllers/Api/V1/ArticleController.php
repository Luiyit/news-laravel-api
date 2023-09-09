<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    /**
     * Retrieve a listing of articles.
     */
    public function index(Request $request)
    {
        $query = Article::query();

        // Search by title
        if ($request->has('q')) {
            $q = $request->input('q');
            $query->whereRaw("LOWER(title) like %", '%' . strtolower($q) . '%');
        }

        // Search by source
        if ($request->has('source_id')) {
            $query->whereIn('source_id', $request->input('source_id'));
        }

        // Search by category
        if ($request->has('category_id')) {
            $query->whereIn('category_id', $request->input('category_id'));
        }

        // Load relationships
        $query->with('category', 'source');

        // Paginate
        $articles = $query->paginate(12);

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
