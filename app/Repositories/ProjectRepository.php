<?php


namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }


    public function all($n)
    {
       return $this->project->paginate($n);
    }

    public function getById($id)
    {
        return $this->project->findOrFail($id);
    }

    public function company($id){
        return $this->getById($id)->company;
    }

    public function status($id){
        return $this->getById($id)->status;
    }

    public function worker($id){
        return $this->getById($id)->worker;
    }

    public function technologies($id){
        return $this->getById($id)->technologies;
    }
}
