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
     * Relationship with Worker class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
