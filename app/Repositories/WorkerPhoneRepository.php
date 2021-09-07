<?php


namespace App\Repositories;


use App\Models\WorkerPhone;
use App\Repositories\Interfaces\WorkerPhoneRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class WorkerPhoneRepository implements WorkerPhoneRepositoryInterface
{
    public $model;

    public function __construct(WorkerPhone $worker_phone)
    {
        $this->model = $worker_phone;
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
    public function worker($id)
    {
        return $this->getById($id)->query()->worker;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }
}
