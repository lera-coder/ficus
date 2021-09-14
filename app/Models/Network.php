<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Testing\Fluent\Concerns\Has;

class Network extends ParentModel
{
    use HasFactory;


    protected $fillable = [
        'name'
    ];


    /**
     * @param $network
     * @return mixed
     */
    public static function checkForExist($network)
    {
        return static::where('name', $network)->firstOr(function () {
            return false;
        });
    }


    /**
     * @return HasMany
     */
    public function users():HasMany
    {
        return $this->hasMany(User::class);
    }


}
