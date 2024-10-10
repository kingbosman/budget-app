<?php

namespace App\Policies;

use App\Models\Income;
use App\Models\User;

class IncomePolicy
{
    public function update(User $user, Income $income)
    {
        return $income->budget->users->contains($user);
    }
}
