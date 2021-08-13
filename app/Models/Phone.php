<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable= [
        'phone_number',
        'two_factor_options',
        'is_active',
        'user_id',
        'phone_country_code_id',
    ];


    /**
     * Function to get User, that have this email
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }



    /**
     * Function to return country code of this phone number
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phoneCountryCode(){
        return $this->BelongsTo(PhoneCountryCode::class);
    }

}
