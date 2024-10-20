<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cost extends Model
{
    use HasFactory;

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function reduced_costs(): hasMany
    {
        return $this->hasMany(Reduced_Cost::class);
    }
}
