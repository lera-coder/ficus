<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return BelongsTo
     */
    public function company():BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return BelongsTo
     */
    public function status():BelongsTo
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    /**
     * @return BelongsTo
     */
    public function worker():BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * @return BelongsToMany
     */
    public function technologies():BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
