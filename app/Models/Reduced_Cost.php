<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reduced_Cost extends Model
{
    use HasFactory;

    public function cost(): belongsTo
    {
        return $this->belongsTo(Cost::class);
    }
}
