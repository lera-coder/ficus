<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerEmail extends ParentModel
{
    use HasFactory;

    protected $fillable = [
        'email',
        'worker_id'
    ];

    /**
     * @return BelongsTo
     */
    public function worker():BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
