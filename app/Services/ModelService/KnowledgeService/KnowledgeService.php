<?php


namespace App\Services\ModelService\KnowledgeService;


use App\Exceptions\UsedTechnologyTypeInKnowledgesException;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;

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

    /**
     * @param $id
     * @param $data
     * @return mixed
     * @throws UsedTechnologyTypeInKnowledgesException
     */
    public function update($id, $data)
    {
        $this->checkIfKnowlegableTypeHasThisTechnology($id, $data);
        return $this->knowledge_repository->getById($id)->update($data);
    }


    /**
     * @param $id
     * @param $data
     * @throws UsedTechnologyTypeInKnowledgesException
     */
    public function checkIfKnowlegableTypeHasThisTechnology($id, $data)
    {
        if (array_key_exists('technology_id', $data)) {
            if ($this->knowledge_repository->
            knowledgeWithThisTechnologyAndKnowledgableType($data['technology_id'], $id)) {

                throw new UsedTechnologyTypeInKnowledgesException
                ($this->getMessageOfKnowledgeException($data['technology_id'], $id));
            }
        }
    }

    /**
     * @param $technology_id
     * @param $knowledge_id
     * @return string
     */
    protected function getMessageOfKnowledgeException($technology_id, $knowledge_id)
    {
        $knowledgable_type =
            substr(str_replace('App\Models', "",
                ($this->knowledge_repository->getById($knowledge_id)->knowledgable_type)), 1);

        $technology = $this->technology_repository->getById($technology_id)->name;
        return $knowledgable_type . ' already has technology ' . $technology;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->knowledge_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->knowledge_repository->model->create($data);
    }
}
