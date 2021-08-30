<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'worker_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker(){
        return $this->belongsTo(Worker::class);
    }
}
