<?php


namespace App\Services\ModelService\KnowledgeService;


use App\Services\ModelService\ModelServiceInterface;

interface KnowledgeServiceInterface extends ModelServiceInterface
{
    public function checkIfKnowlegableTypeHasThisTechnology($id, $data);

}
