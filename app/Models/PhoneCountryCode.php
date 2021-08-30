<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCountryCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'country'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones(){
        return $this->hasMany(Phone::class);
    }
}
