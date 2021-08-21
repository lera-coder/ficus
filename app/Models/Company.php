<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'contact_information'
    ];


    /**
     * Relationship with Worker class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workers(){
        return $this->hasMany(Worker::class);
    }


    /**
     * Relationship with Project class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){
        return $this->hasMany(Project::class);
    }
}

