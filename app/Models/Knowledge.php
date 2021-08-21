<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
     * Relationship with Level class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function level(){
        return $this->belongsTo(Level::class);
    }

    /**
     * Relationship to applicants and users
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function knowledgable(){
        return $this->morphTo();
    }

    /**
     * Relationship with Technology class
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technology(){
        return $this->BelongsTo(Technology::class);
    }

}
