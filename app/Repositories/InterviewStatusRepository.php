<?php


namespace App\Repositories;


use App\Models\InterviewStatus;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;

class InterviewStatusRepository implements InterviewStatusRepositoryInterface
{

    public $interviewStatus;

    public function __construct(InterviewStatus $interviewStatus)
    {
        $this->interviewStatus = $interviewStatus;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->interviewStatus->query()->paginate($n);
    }

    /**
     * @param $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getById($id)
    {
        return $this->interviewStatus->query()->findOrFail($id);
    }

    /**
     * @return array
     */
    public function getAllIds()
    {
        return $this->interviewStatus->all()->pluck('id')->toArray();
    }

    /**
     * @param $statuses_array
     * @return array
     */
    public function getIdsForFiltration($statuses_array)
    {
        $statuses_id_array = [];
        foreach ($statuses_array as $status) {
            $id = $this->getIdByName(str_replace('-', ' ', $status));
            array_push($statuses_id_array, $id);
        }
        return $statuses_id_array;
    }

    /**
     * @param $status_name
     * @return HigherOrderBuilderProxy|mixed|null
     */
    public function getIdByName($status_name)
    {
        $model = $this->interviewStatus->query()->where('name', $status_name)->first();
        return $model ? $model->id : null;
    }
}
