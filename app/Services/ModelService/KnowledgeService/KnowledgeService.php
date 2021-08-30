<?php


namespace App\Services\ModelService\KnowledgeService;


use App\Exceptions\TransactionFailedException;
use App\Exceptions\UsedTechnologyTypeInKnowledgesException;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;
use function PHPUnit\Framework\throwException;

class KnowledgeService implements KnowledgeServiceInterface
{

    protected $knowledge_repository;
    protected $technology_repository;

    public function __construct(KnowledgeRepositoryInterface $knowledge_repository,
                                TechnologyRepositoryInterface $technology_repository)
    {
        $this->knowledge_repository = $knowledge_repository;
        $this->technology_repository = $technology_repository;
    }

    public function update($id, $data)
    {
        $this->checkIfKnowlegableTypeHasThisTechnology($id, $data);
        return $this->knowledge_repository->getById($id)->update($data);
    }

    public function checkIfKnowlegableTypeHasThisTechnology($id, $data){
        if(array_key_exists('technology_id', $data)){
            if($this->knowledge_repository->knowledgeWithThisTechnologyAndKnowledgableType($data['technology_id'], $id)){
                throw new UsedTechnologyTypeInKnowledgesException($this->getMessageOfKnowledgeException($data['technology_id'], $id));
            }
        }
    }


    protected function getMessageOfKnowledgeException($technology_id, $knowledge_id){
        $knowledgable_type = substr(str_replace('App\Models',"", ($this->knowledge_repository->getById($knowledge_id)->knowledgable_type)), 1);
        $technology = $this->technology_repository->getById($technology_id)->name;
        return $knowledgable_type.' already has technology '.$technology;
    }

    public function destroy($id)
    {
        return $this->knowledge_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->knowledge_repository->knowledge->create($data);
    }
}
