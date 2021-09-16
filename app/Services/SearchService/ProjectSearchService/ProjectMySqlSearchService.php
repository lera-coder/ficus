<?php


namespace App\Services\SearchService\ProjectSearchService;


use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectMySqlSearchService implements ProjectSearchServiceInterface
{
    protected $project_repository;

    public function __construct(ProjectRepositoryInterface $project_repository)
    {
        $this->project_repository = $project_repository;
    }

    public function search(string $query)
    {
        return $this->project_repository->search($query);
    }
}