<?php


namespace App\Repositories;


use App\Models\WorkerStatus;
use App\Repositories\Interfaces\WorkerStatusRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class WorkerStatusRepository implements WorkerStatusRepositoryInterface
{
    public $worker_status;

    public function __construct(WorkerStatus $worker_status)
    {
        $this->worker_status = $worker_status;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->worker_status->query()->paginate($n);
    }

    /**
     * @param $id
     * @return HigherOrderBuilderProxy|mixed
     */
    public function workers($id)
    {
        return $this->getById($id)->query()->workers;
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->worker_status->query()->findOrFail($id);
    }
}
