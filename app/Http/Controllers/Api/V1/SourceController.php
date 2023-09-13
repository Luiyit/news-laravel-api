<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSourceRequest;
use App\Http\Requests\UpdateSourceRequest;
use App\Http\Resources\SourceResource;
use App\Models\Source;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $preferableIds = [];

        if($user !== null){
            $preferable = $user->preferences->where('preferable_type', 'App\\Models\\Source');
            $preferableIds = $preferable->pluck('preferable_id')->toArray();
        }

        if(count($preferableIds) === 0)
            return SourceResource::collection(Source::all());

        return SourceResource::collection(Source::whereIn('id', $preferableIds)->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        return SourceResource::make($source);
    }
}
