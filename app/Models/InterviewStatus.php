<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InterviewStatus extends ParentModel
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function interviews(): HasMany
    {
        return $this->hasMany(Interview::class);
    }
}
