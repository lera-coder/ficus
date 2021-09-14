<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerPhone extends ParentModel
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'operator',
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
