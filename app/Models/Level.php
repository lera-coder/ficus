<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends ParentModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * @return HasMany
     */
    public function knowledges(): HasMany
    {
        return $this->hasMany(Knowledge::class);
    }

}
