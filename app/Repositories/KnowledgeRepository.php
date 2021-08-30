<?php


namespace App\Repositories;


use App\Models\Knowledge;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;

class KnowledgeRepository implements KnowledgeRepositoryInterface
{
    public $knowledge;

    public function __construct(Knowledge $knowledge)
    {
        $this->knowledge = $knowledge;
    }

    public function all($n)
    {
        return $this->knowledge->paginate($n);
    }

    public function getById($id)
    {
        return $this->knowledge->findOrFail($id);
    }

    public function knowledgable($id){
        return $this->getById($id)->knowledgable;
    }

    public function technology($id){
        return $this->getById($id)->technology;
    }

    public function level($id){
        return $this->getById($id)->level;
    }

    public function knowledgeWithThisTechnologyAndKnowledgableType($technology_id, $knowledge_id){
        $knowledge = $this->getById($knowledge_id);
        return $this->knowledge ->where('knowledgable_type',$knowledge->knowledgable_type)
                                ->where('knowledgable_id', $knowledge->knowledgable_id)
                                ->where('technology_id', $technology_id)
//                                ->skip($knowledge)
                                ->get();

    }


}
