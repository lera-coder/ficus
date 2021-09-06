<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Knowledge extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'year_start',
        'description',
        'knowledgable_type',
        'knowledgable_id',
        'technology_id',
        'level_id',
    ];


    /**
     * @return BelongsTo
     */
    public function level():BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    /**
     * @return MorphTo
     */
    public function knowledgable():MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function technology():BelongsTo
    {
        return $this->BelongsTo(Technology::class);
    }

}
