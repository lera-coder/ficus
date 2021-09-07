<?php


namespace App\Repositories;


use App\Models\Level;
use App\Repositories\Interfaces\LevelRepositoryInterface;

class LevelRepository implements LevelRepositoryInterface
{
    public $model;

    public function __construct(Level $level)
    {
        $this->model = $level;
    }

    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param Level $id
     * @return mixed
     */
    public function knowledges($id)
    {
        return $this->getById($id)->knowledges;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

}
