<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Level;
use App\Repositories\Interfaces\LevelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LevelRepository implements LevelRepositoryInterface
{
    public Level $model;

    public function __construct(Level $level)
    {
        $this->model = $level;
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
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function knowledges(int $id):Collection
    {
        return $this->getById($id)->knowledges;
    }

    /**
     * @param int $id
     * @return Level
     * @throws ModelNotFoundException
     */
    public function getById(int $id):Level
    {
        return $this->model->getModel($id);
    }


}
