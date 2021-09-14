<?php

namespace App\Models;

use App\Exceptions\ModelNotFoundException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentModel extends Model
{
    use HasFactory;

    /**
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public static function getModel($id)
    {
        $model = static::find($id);

        if (is_null($model)) {
            throw new ModelNotFoundException;
        }
        return $model;
    }
}
