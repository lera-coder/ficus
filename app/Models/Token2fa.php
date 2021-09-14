<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Token2fa extends ParentModel
{
    use HasFactory;

    protected $fillable = [
        "token",
        "user_id",
        "is_confirmed"
    ];


    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class);
    }
}
