<?php


namespace App\Repositories;


use App\Models\Worker;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class WorkerRepository implements WorkerRepositoryInterface
{
    public $model;

    public function __construct(Worker $worker)
    {
        return $this->model = $worker;
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
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function emails($id)
    {
        return $this->getById($id)->query()->emails;
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
    public function phones($id)
    {
        return $this->getById($id)->query()->phones;
    }


    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function position($id)
    {
        return $this->getById($id)->query()->position;
    }


    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function status($id)
    {
        return $this->getById($id)->query()->status;
    }


    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function company($id)
    {
        return $this->getById($id)->query()->company;
    }


    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function projects($id)
    {
        return $this->getById($id)->query()->projects;
    }
}
