<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'contact_information'
    ];


    /**
     * @return HasMany
     */
    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }


    /**
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}

