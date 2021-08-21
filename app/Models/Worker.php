<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'status_id',
        'position_id'
    ];


    /**
     * Relationship with Email class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails(){
        return $this->hasMany(WorkerEmail::class);
    }

    /**
     * Relationship with Phone class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones(){
        return $this->hasMany(WorkerEmail::class);
    }

    /**
     * Relationship with Status class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(){
        return $this->belongsTo(WorkerStatus::class);
    }

    /**
     * Relationship with WorkerPosition class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(){
        return $this->belongsTo(WorkerPosition::class);
    }

    /**
     * Relationship with Company class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship with Project class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects(){
        return $this->hasMany(Project::class);
    }

}
