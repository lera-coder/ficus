<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Technology extends ParentModel
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
    public function knowledges()
    {
        return $this->hasMany(Project::class);
    }


    /**
     * @return BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Technology::class);
    }

}
