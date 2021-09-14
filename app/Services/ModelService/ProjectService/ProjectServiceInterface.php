<?php


namespace App\Services\ModelService\ProjectService;


use App\Services\ModelService\ModelServiceInterface;

interface ProjectServiceInterface extends ModelServiceInterface
{
    public function checkWorkerAndCompanyForMatch(array $data);

    public function countPriceProjectByDefault(float $price);

}
