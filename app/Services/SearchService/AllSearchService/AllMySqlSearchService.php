<?php


namespace App\Services\SearchService\AllSearchService;


use App\Http\Resources\ProjectResources\ProjectFullResourceCollection;
use App\Http\Resources\UserResources\UserFullResourceCollection;
use App\Services\SearchService\ProjectSearchService\ProjectSearchServiceInterface;
use App\Services\SearchService\UserSearchService\UserSearchServiceInterface;

class AllMySqlSearchService implements AllSearchServiceInterface
{
    protected $userSearchService;
    protected $projectSearchService;

    public function __construct(UserSearchServiceInterface $userSearchService,
                                ProjectSearchServiceInterface $projectSearchService)
    {
        $this->userSearchService = $userSearchService;
        $this->projectSearchService = $projectSearchService;
    }

    public function search(string $query)
    {
        $users = new UserFullResourceCollection($this->userSearchService->search($query));
        $projects = new ProjectFullResourceCollection($this->projectSearchService->search($query));
        return $users->merge($projects);
    }
}