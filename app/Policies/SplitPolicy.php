<?php

namespace App\Policies;

use App\Models\Split;
use App\Models\User;

class SplitPolicy
{
    public function update(User $user, Split $split)
    {
        return $split->budget->users->contains($user);
    }
}
