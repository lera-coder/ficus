<?php


namespace App\Services\ModelService\WorkerPositionService;


use App\Repositories\Interfaces\WorkerPositionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WorkerPositionService implements WorkerPositionServiceInterface
{

    protected $worker_position_repository;

    public function __construct(WorkerPositionRepositoryInterface $worker_position_repository)
    {
        $this->worker_position_repository = $worker_position_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->worker_position_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->worker_position_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function create($data)
    {
        return $this->worker_position_repository->model->query()->create($data);
    }
}
