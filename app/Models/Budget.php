<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Budget extends Pivot
{
    use HasFactory;

    protected $table = 'budgets';
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

}
