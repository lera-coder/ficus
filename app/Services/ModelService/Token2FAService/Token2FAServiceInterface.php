<?php


namespace App\Services\ModelService\Token2FAService;


use App\Services\ModelService\ModelServiceInterface;

interface Token2FAServiceInterface extends ModelServiceInterface
{
    public function create($user_id);

}
