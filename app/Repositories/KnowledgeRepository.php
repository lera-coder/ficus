<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Knowledge;
use App\Models\Level;
use App\Models\Technology;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class KnowledgeRepository implements KnowledgeRepositoryInterface
{
    public $model;

    public function __construct(Knowledge $knowledge)
    {
        $this->model = $knowledge;
    }

    /**
     * @param int $n
     * @return LengthAwarePaginator
     */
    public function all(int $n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return Knowledge
     * @throws ModelNotFoundException
     */
    public function getById(int $id):Knowledge
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function knowledgable(int $id):mixed
    {
        return $this->getById($id)->query()->knowledgable;
    }



    /**
     * @param int $id
     * @return Technology
     * @throws ModelNotFoundException
     */
    public function technology(int $id): Technology
    {
        return $this->getById($id)->query()->technology;
    }

    /**
     * @param int $id
     * @return Level
     * @throws ModelNotFoundException
     */
    public function level(int $id): Level
    {
        return $this->getById($id)->query()->level;
    }


    /**
     * @param int $technology_id
     * @param int $knowledge_id
     * @return Builder[]|Collection
     * @throws ModelNotFoundException
     */
    public function knowledgeWithThisTechnologyAndKnowledgableType
    (int $technology_id, int $knowledge_id): ?Collection
    {
        $knowledge = $this->getById($knowledge_id);
        return $this->model->query()->where('knowledgable_type', $knowledge->knowledgable_type)
            ->where('knowledgable_id', $knowledge->knowledgable_id)
            ->where('technology_id', $technology_id)
            ->get();
    }


}
