<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token2fa extends Model
{
    use HasFactory;


    /**
     * Function, that returns user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->BelongsTo(User::class);
    }
}
