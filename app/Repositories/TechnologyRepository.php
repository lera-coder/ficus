<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Technology;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TechnologyRepository implements TechnologyRepositoryInterface
{
    public Technology $model;

    public function __construct(Technology $technology)
    {
        $this->model = $technology;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function knowledges(int $id)
    {
        return $this->getById($id)->query()->knowledges;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getById(int $id)
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function projects(int $id)
    {
        return $this->getById($id)->query()->projects;
    }


}
