<?php


namespace App\Services\ModelService\PhoneService;


use App\Services\ModelService\ModelServiceInterface;

interface PhoneServiceInterface extends ModelServiceInterface
{
    public function makeActive($id);

}
