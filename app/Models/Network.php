<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;


    /**
     * Function to check was this network connected to this app or no
     * @param $network
     * @return mixed
     */
    public static function checkForExist($network){
        return static::where('name', $network)->firstOr(function (){
                return false;
            }
        );
    }

}
