<?php


namespace App\Services\ModelService\NetworkService;


use App\Exceptions\InvalidNetworkConnectException;
use App\Repositories\Interfaces\NetworkRepositoryInterface;

class NetworkService implements NetworkServiceInterface
{
    protected $network_repository;

    public function __construct(NetworkRepositoryInterface $network_repository)
    {
        $this->network_repository = $network_repository;
    }

    /**
     * @param $network
     * @throws InvalidNetworkConnectException
     */
    public function checkNetworkExistance($network)
    {
        $models_quantity = $this->network_repository->checkSocialNetworkForExistance($network)->count();
        if ($models_quantity == 0) throw new InvalidNetworkConnectException();
    }

}
