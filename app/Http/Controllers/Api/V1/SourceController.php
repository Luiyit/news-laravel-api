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
        return SourceResource::collection(Source::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Source $source)
    {
        return SourceResource::make($source);
    }
}
