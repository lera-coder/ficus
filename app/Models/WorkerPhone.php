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
     * Relationship with Worker class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }
}
