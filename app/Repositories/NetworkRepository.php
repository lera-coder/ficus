<?php


namespace App\Repositories;


use App\Models\Network;
use App\Repositories\Interfaces\NetworkRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NetworkRepository implements NetworkRepositoryInterface
{
    protected $network;

    public function __construct(Network $network)
    {
        $this->network = $network;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n)
    {
        return $this->network->query()->paginate($n);
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
        return $this->network->query()->findOrFail($id);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getModelByName($name)
    {
        return $this->network->where('name', $name)->firstOrFail();
    }


    /**
     * @param $network
     * @return mixed
     */
    public function checkSocialNetworkForExistance($network)
    {
        return $this->network->where('name', $network)->get();
    }
}
