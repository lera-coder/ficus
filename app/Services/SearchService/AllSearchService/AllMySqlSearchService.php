<?php


namespace App\Services\SearchService\AllSearchService;


use App\Http\Resources\PaginateItemsSearch\PaginateItemsCollection;
use App\Http\Resources\ProjectResources\ProjectFullResourceCollection;
use App\Http\Resources\UserResources\UserFullResourceCollection;
use App\Services\SearchService\ProjectSearchService\ProjectSearchServiceInterface;
use App\Services\SearchService\UserSearchService\UserSearchServiceInterface;
use Illuminate\Support\Facades\DB;

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
        $users = $this->userSearchService->search($query);
        $users = $users->select('users.*')->addSelect(DB::raw("'User' as 'model'"));
        $projects = $this->projectSearchService->search($query);
        $projects = $projects->select('projects.*')->addSelect(DB::raw("'Project' as 'model'"));
//        return $projects->union($users)->paginate(20);
        return new PaginateItemsCollection($projects->union($users)->paginate(20));
    }
}