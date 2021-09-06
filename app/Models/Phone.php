<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'two_factor_options',
        'is_active',
        'user_id',
        'phone_country_code_id',
    ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * @return BelongsTo
     */
    public function phoneCountryCode(): BelongsTo
    {
        return $this->BelongsTo(PhoneCountryCode::class);
    }


    /**
     * @method static active() get active phone of user
     * @return Builder
     */
    public function scopeActive($query): Builder
    {
        return $query->where('is_active', 1);
    }

    /**
     * @method static notActive() get not active phone of user
     * @return Builder
     */
    public function scopeNotActive($query): Builder
    {
        return $query->where('is_active', 0);
    }

}
