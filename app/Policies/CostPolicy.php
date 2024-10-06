<?php

namespace App\Policies;

use App\Models\Cost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CostPolicy
{


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $cost->budget->users->contains($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Cost $cost): bool
    {
        return $cost->budget->users->contains($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Cost $cost): bool
    {
        return $cost->budget->users->contains($user);
    }
}
