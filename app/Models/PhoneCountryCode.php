<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhoneCountryCode extends ParentModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'country'
    ];


    /**
     * @return HasMany
     */
    public function phones():HasMany
    {
        return $this->hasMany(Phone::class);
    }
}
