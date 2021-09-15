<?php


namespace App\Repositories;


use App\Exceptions\ModelNotFoundException;
use App\Models\Network;
use App\Repositories\Interfaces\NetworkRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
    public function all($n): LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function users(int $id): Collection
    {
        return $this->getById($id)->users;
    }

    /**
     * @param int $id
     * @return Network
     * @throws ModelNotFoundException
     */
    public function getById(int $id): Network
    {
        return $this->model->getModel($id);
    }

    /**
     * @param string $name
     * @return Network
     */
    public function getModelByName(string $name): Network
    {
        return $this->model->where('name', $name)->firstOrFail();
    }


    /**
     * @param string $network
     * @return Network
     */
    public function checkSocialNetworkForExistence(string $network): Network
    {
        return $this->model->where('name', $network)->first();
    }
}
