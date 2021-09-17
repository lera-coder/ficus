<?php


namespace App\Repositories;

use App\Exceptions\ModelNotFoundException;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Worker;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProjectRepository implements ProjectRepositoryInterface
{
    public $model;

    public function __construct(Project $project)
    {
        $this->model = $project;
    }

    /**
     * @param $n
     * @return LengthAwarePaginator
     */
    public function all($n):LengthAwarePaginator
    {
        return $this->model->query()->paginate($n);
    }

    /**
     * @param int $id
     * @return Company
     * @throws ModelNotFoundException
     */
    public function company(int $id): Company
    {
        return $this->getById($id)->company;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function getById(int $id)
    {
        return $this->model->getModel($id);
    }

    /**
     * @param int $id
     * @return ProjectStatus
     * @throws ModelNotFoundException
     */
    public function status(int $id): ProjectStatus
    {
        return $this->getById($id)->status;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ModelNotFoundException
     */
    public function users(int $id){
        return $this->getById($id)->users;
    }


    /**
     * @param int $id
     * @return Worker
     * @throws ModelNotFoundException
     */
    public function worker(int $id): Worker
    {
        return $this->getById($id)->worker;
    }


    /**
     * @param int $id
     * @return Collection
     * @throws ModelNotFoundException
     */
    public function technologies(int $id): Collection
    {
        return $this->getById($id)->technologies;
    }

    /**
     * @param string $query
     * @return \Illuminate\Database\Query\Builder
     */
    public function search(string $query){
        $projects = DB::table('projects')
            ->join('companies', 'companies.id', '=', 'projects.company_id')
            ->select('projects.*', 'companies.name')
            ->where('companies.name', 'like', "%{$query}%")
            ->oRwhere('projects.name', 'like', "%{$query}%")
            ->oRwhere('projects.description', 'like', "%{$query}%")
            ->pluck('id')->toArray();

        return DB::table('projects')->whereIn('id', array_unique($projects));
    }
}
