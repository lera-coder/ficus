<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneCountryCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'country'
    ];


    /**
     * Function to return all phones, that have this country code
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function phones(){
        return $this->hasMany(Phone::class);
    }
}
