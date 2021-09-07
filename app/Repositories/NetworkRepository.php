<?php


namespace App\Repositories;


use App\Models\Network;
use App\Repositories\Interfaces\NetworkRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NetworkRepository implements NetworkRepositoryInterface
{
    protected $model;

    public function __construct(Network $network)
    {
        $this->model = $network;
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
     * @return mixed
     */
    public function users($id)
    {
        return $this->getById($id)->users;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getModelByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }


    /**
     * @param $network
     * @return mixed
     */
    public function checkSocialNetworkForExistance($network)
    {
        return $this->model->where('name', $network)->get();
    }
}
