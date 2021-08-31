<?php


namespace App\Repositories;


use App\Models\Network;
use App\Repositories\Interfaces\NetworkRepositoryInterface;

class NetworkRepository implements NetworkRepositoryInterface
{
    protected $network;

    public function __construct(Network $network)
    {
        $this->network = $network;
    }

    public function all($n)
    {
        return $this->network->paginate($n);
    }

    public function getById($id)
    {
        return $this->network->findOrFail($id);
    }

    public function users($id){
        return $this->getById($id)->users;
    }

    public function getModelByName($name){
        return $this->network->where('name', $name)->firstOrFail();
    }

    public function checkSocialNetworkForExistance($network){
        return $this->network->where('name', $network)->get();
    }
}
