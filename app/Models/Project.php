<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'company_id',
        'status_id',
        'worker_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(){
        return $this->belongsTo(Company::class);
    }

    /**
     * Relationship with class Status Project
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status(){
        return $this->belongsTo(ProjectStatus::class);
    }

    /**
     * Relationship with class Worker
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker(){
        return $this->belongsTo(Worker::class);
    }

    /**
     * Relationship with Technology class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function technologies(){
        return $this->belongsToMany(Project::class);
    }
}
