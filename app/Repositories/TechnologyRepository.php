<?php


namespace App\Repositories;


use App\Models\Technology;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\HigherOrderBuilderProxy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HigherOrderCollectionProxy;

class TechnologyRepository implements TechnologyRepositoryInterface
{
    public $model;

    public function __construct(Technology $technology)
    {
        $this->model = $technology;
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
    public function knowledges($id)
    {
        return $this->getById($id)->query()->knowledges;
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
     * @return HigherOrderBuilderProxy|HigherOrderCollectionProxy|mixed
     */
    public function projects($id)
    {
        return $this->getById($id)->query()->projects;
    }


}
