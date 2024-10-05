<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;

class BudgetPolicy
{

    public function show(User $user, Budget $budget)
    {
        return $budget->users->contains($user);
    }

    public function update(User $user, Budget $budget)
    {
        // create model for admin privileges and replace below to only admin instead of all users
        return $budget->users->contains($user);
    }

}
