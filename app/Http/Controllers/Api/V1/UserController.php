<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException as DuplicateException;

class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create($request->validated());
            return UserResource::make($user);
        } catch (DuplicateException $th) {
            return response()->json([
                "message" => "The email field is already in use.",
                'errors' => [
                    "email" => ["The email field is already in use."]
                ]
            ], 422);
        }
    }
}
