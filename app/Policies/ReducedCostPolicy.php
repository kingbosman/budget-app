<?php

namespace App\Policies;

use App\Models\ReducedCost;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReducedCostPolicy
{

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ReducedCost $reducedCost): bool
    {
        return $reducedCost->cost->budget->users->contains($user);
    }

}
