<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPosition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    /**
     * Relationship with Worker class
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workers(){
        return $this->hasMany(Worker::class);
    }

}
