<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;


    protected $fillable =[
        'name'
    ];


    /**
     * @param $network
     * @return mixed
     */
    public static function checkForExist($network){
        return static::where('name', $network)->firstOr(function (){
                return false;
            }
        );
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(){
        return $this->hasMany(User::class);
    }



}
