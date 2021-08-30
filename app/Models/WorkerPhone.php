<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'operator',
        'worker_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function worker(){
        return $this->belongsTo(Worker::class);
    }
}
