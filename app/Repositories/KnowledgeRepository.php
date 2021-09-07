<?php


namespace App\Repositories;


use App\Models\Knowledge;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class KnowledgeRepository implements KnowledgeRepositoryInterface
{
    public $model;

    public function __construct(Knowledge $knowledge)
    {
        $this->model = $knowledge;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function knowledgable($id)
    {
        return $this->getById($id)->query()->knowledgable;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function technology($id)
    {
        return $this->getById($id)->query()->technology;
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function level($id)
    {
        return $this->getById($id)->query()->level;
    }


    /**
     * @param $technology_id
     * @param $knowledge_id
     * @return Builder[]|Collection
     */
    public function knowledgeWithThisTechnologyAndKnowledgableType($technology_id, $knowledge_id)
    {
        $knowledge = $this->getById($knowledge_id);
        return $this->model->query()->where('knowledgable_type', $knowledge->knowledgable_type)
            ->where('knowledgable_id', $knowledge->knowledgable_id)
            ->where('technology_id', $technology_id)
            ->get();

    }


}
