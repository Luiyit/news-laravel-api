<?php

namespace App\Policies;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PreferencePolicy
{
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Preference $preference): bool
    {
        return $user->id === $preference->user_id;
    }
}
