<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder;

/**
 * @mixin Builder
 * Class Email
 * @package App\Models
 */
class Email extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'is_active',
        'user_id'
    ];


    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    /**
     * @method static active() get active email of user
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    /**
     * @method static notActive() get active email of user
     * @param $query
     * @return mixed
     */
    public function scopeNotActive($query)
    {
        return $query->where('is_active', 0);
    }
}
