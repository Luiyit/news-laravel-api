<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StorePreferenceRequest;
use App\Models\Preference;
use App\Http\Resources\PreferenceResource;
use Illuminate\Auth\Access\AuthorizationException;
use Exception;

class PreferenceController extends Controller
{
    /**
     * Retrieve list of user's preference
     */
    public function index()
    {
        $user = auth()->user();
        $preferences = Preference::where('user_id', $user->id)->with('preferable')->get();

        // Send response
        return PreferenceResource::collection($preferences);
    }

    /**
     * Store a newly created preference in storage.
     */
    public function store(StorePreferenceRequest $request)
    {
        $preferenceData = $request->validated();
        $type = $preferenceData['preferable_type'];

        $user = auth()->user();
        $preferenceData['user_id'] = $user->id;
        $preferenceData['preferable_type'] = "App\\Models\\".$type;

        try
        {
            $preference = Preference::create($preferenceData);
            $preference->preferable;

            // Send response
            return PreferenceResource::make($preference);
        }
        catch (Exception  $e)
        {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Remove the specific preference from storage
     */
    public function destroy(Preference $preference)
    {
        try
        {
            $this->authorize('delete', $preference);
            $preference->delete();
            return response()->noContent();
        }
        catch (AuthorizationException $e)
        {
            return response()->json(['message' => $e->getMessage()], 422);
        }


    }
}
