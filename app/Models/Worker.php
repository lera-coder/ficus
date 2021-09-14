<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return HasMany
     */
    public function emails():HasMany
    {
        return $this->hasMany(WorkerEmail::class);
    }

    /**
     * @return HasMany
     */
    public function phones():HasMany
    {
        return $this->hasMany(WorkerPhone::class);
    }

    /**
     * @return BelongsTo
     */
    public function status():HasMany
    {
        return $this->belongsTo(WorkerStatus::class);
    }

    /**
     * @return BelongsTo
     */
    public function position():HasMany
    {
        return $this->belongsTo(WorkerPosition::class);
    }

    /**
     * @return belongsTo
     */
    public function company():belongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return HasMany
     */
    public function projects():HasMany
    {
        return $this->hasMany(Project::class);
    }

}
