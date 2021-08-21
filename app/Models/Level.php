<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * Relationship with Knowledge class
     * @return Level|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function knowledges(){
        return $this-$this->hasMany(Knowledge::class);
    }

}
