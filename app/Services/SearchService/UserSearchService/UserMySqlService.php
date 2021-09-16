<?php


namespace App\Services\SearchService\UserSearchService;


use App\Repositories\Interfaces\UserRepositoryInterface;

class UserMySqlService implements UserSearchServiceInterface
{
    protected $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @param string $query
     * @return mixed
     */
    public function search(string $query)
    {
        return $this->user_repository->search($query);
    }
}