<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $preferableIds = [];

        if($user !== null){
            $preferable = $user->preferences->where('preferable_type', 'App\\Models\\Category');
            $preferableIds = $preferable->pluck('preferable_id')->toArray();
        }

        if(count($preferableIds) === 0)
            return CategoryResource::collection(Category::all());

        return CategoryResource::collection(Category::whereIn('id', $preferableIds)->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return CategoryResource::make($category);
    }
}
