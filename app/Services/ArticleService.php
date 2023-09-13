<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Article;

/**
 * Retrieve articles based on query string and user preference
 */
class ArticleService
{
    /**
     * Current user
     */
    private $user;

    /**
     * Request query
     */
    private $request;

    /**
     * Article query
     */
    private $query;

    /**
     * Set required attributes
     */
    public function __construct(User $user = null, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
        $this->query = Article::query();
    }

    /**
     * Retrieve article list based on query and use preferences
     *
     * @return App\Models\Article []
     */
    public function getArticlesForUser()
    {
        $this->withSourcesIds();
        $this->withCategoryIds();
        $this->withQuery();
        $this->loadRelationships();

        return $this->paginate();
    }

    /**
     * Include user search in query
     */
    private function withQuery()
    {
        $q = $this->request->input('q');
        if ($q) $this->query->whereRaw("LOWER(title) like '%" . strtolower($q) . "%'");

    }

    /**
     * Include sources in article query
     */
    private function withSourcesIds()
    {
        $querySource = $this->request->input('source_id');
        if ($querySource)
            $this->query->whereIn('source_id', [$querySource] );

        else {
            $userSourceIds = $this->userPreference('Source');
            if(count($userSourceIds) > 0)
                $this->query->whereIn('source_id', $userSourceIds);
        }
    }

    /**
     * Include categories in article query
     */
    private function withCategoryIds()
    {
        $queryCategory = $this->request->input('category_id');
        if ($queryCategory)
            $this->query->whereIn('category_id', [$queryCategory] );

        else {
            $userCategoryIds = $this->userPreference('Category');
            if(count($userCategoryIds) > 0)
                $this->query->orWhereIn('category_id', $userCategoryIds);
        }
    }

    /**
     * Retrieve user preferences
     */
    private function userPreference($type)
    {
        if($this->user === null) return [];

        $preferable = $this->user->preferences->where('preferable_type', 'App\\Models\\'.$type);

        if ($preferable->isEmpty())
            return [];

        return $preferable->pluck('preferable_id')->toArray();
    }

    /**
     * Load relationships
     */
    private function loadRelationships(){
        $this->query->with('category', 'source');
    }

    private function paginate()
    {
        $page = $this->request->input('page');
        if (!$page) $page = $page = 1;

        return $this->query->paginate(12, ['*'], 'page', $page);
    }
}
