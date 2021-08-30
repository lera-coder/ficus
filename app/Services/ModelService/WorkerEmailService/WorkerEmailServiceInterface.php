<?php


namespace App\Services\ModelService\WorkerEmailService;


use App\Services\ModelService\ModelServiceInterface;

interface WorkerEmailServiceInterface extends ModelServiceInterface
{
    public function create($data);

}
