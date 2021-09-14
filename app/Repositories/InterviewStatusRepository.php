<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\InterviewStatus;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class InterviewStatusRepository implements InterviewStatusRepositoryInterface
{

    public InterviewStatus $model;

    public function __construct(InterviewStatus $interviewStatus)
    {
        $this->model = $interviewStatus;
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
     * @return InterviewStatus
     * @throws ModelNotFoundException
     */
    public function getById(int $id):InterviewStatus
    {
        return $this->model->getModel($id);
    }

    /**
     * @return array
     */
    public function getAllIds(): array
    {
        return $this->model->all()->pluck('id')->toArray();
    }

    /**
     * @param array $statuses_array
     * @return array
     */
    public function getIdsForFiltration(array $statuses_array): array
    {
        $statuses_id_array = [];
        foreach ($statuses_array as $status) {
            $id = $this->getIdByName(str_replace('-', ' ', $status));
            array_push($statuses_id_array, $id);
        }
        return $statuses_id_array;
    }

    /**
     * @param string $status_name
     * @return int|null
     */
    public function getIdByName(string $status_name): ?int
    {
        $model = $this->model->query()->where('name', $status_name)->first();
        return $model ? $model->id : null;
    }
}
