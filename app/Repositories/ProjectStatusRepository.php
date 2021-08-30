<?php


namespace App\Repositories;


use App\Models\ProjectStatus;
use App\Repositories\Interfaces\ProjectStatusRepositoryInterface;

class ProjectStatusRepository implements ProjectStatusRepositoryInterface
{
    public $project_status;

    public function __construct(ProjectStatus $project_status)
    {
        $this->project_status = $project_status;
    }

    public function all($n)
    {
        return $this->project_status->paginate($n);
    }

    public function getById($id)
    {
        return $this->project_status->findOrFail($id);
    }

    public function projects($id){
        return $this->getById($id)->projects;
    }
}
