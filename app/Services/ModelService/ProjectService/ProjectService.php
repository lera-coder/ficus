<?php


namespace App\Services\ModelService\ProjectService;


use App\Exceptions\TransactionFailedException;
use App\Exceptions\WorkerNotInThisCompanyException;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;


class ProjectService implements ProjectServiceInterface
{
    protected $project_repository;
    protected $worker_repository;

    public function __construct(ProjectRepositoryInterface $project_repository,
                                WorkerRepositoryInterface $worker_repository)
    {
        $this->project_repository = $project_repository;
        $this->worker_repository = $worker_repository;
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws TransactionFailedException
     * @throws WorkerNotInThisCompanyException
     */
    public function update(int $id, array $data)
    {
        $data_edited = $this->checkWorkerAndCompanyForMatch($data);

        try {
            DB::beginTransaction();
            $this->project_repository->getById($id)->update($data_edited);
            if (isset($data_edited['technologies'])) {
                $this->deletePivotTechnologies($id);
                $this->addProjectsTechnologies($data_edited, $id);
            }

            if (isset($data_edited['users'])) {
                $this->deletePivotUsers($id);
                $this->addUsersProjects($data_edited, $id);
            }
            DB::commit();
            return $this->project_repository->getById($id);
        } catch (Exception $exception) {
            DB::rollBack();
            throw new TransactionFailedException();
        }
    }

    /**
     * @param array $data
     * @return mixed
     * @throws WorkerNotInThisCompanyException
     */
    public function checkWorkerAndCompanyForMatch(array $data)
    {
        if (array_key_exists('worker_id', $data)) {
            if (array_key_exists('company_id', $data)) {
                if ($this->worker_repository->company($data['worker_id'])->id == $data['company_id']) {
                    return $data;
                } else {
                    throw new WorkerNotInThisCompanyException();
                }
            } else {
                $data['company_id'] = $this->worker_repository->company($data['worker_id'])->id;
            }
        }
        return $data;
    }

    /**
     * @param int $id
     */
    protected function deletePivotTechnologies(int $id)
    {
        DB::table('projects_technologies')->where('project_id', '=', $id)->delete();
    }

    /**
     * @param array $data
     * @param int $project_id
     */
    protected function addProjectsTechnologies($data, $project_id)
    {
        if (isset($data['technologies'])) {
            foreach ($data['technologies'] as $user_id) {
                DB::table('projects_technologies')->insert(
                    ['technology_id' => $user_id, 'project_id' => $project_id]);
            }
        }
    }

    /**
     * @param int $id
     */
    protected function deletePivotUsers(int $id)
    {
        DB::table('users_projects')->where('project_id', '=', $id)->delete();
    }

    /**
     * @param array $data
     * @param int $project_id
     */
    protected function addUsersProjects(array $data, int $project_id)
    {
        if (isset($data['users'])) {
            foreach ($data['users'] as $user_id) {
                DB::table('users_projects')->insert(
                    ['user_id' => $user_id, 'project_id' => $project_id]);
            }
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws TransactionFailedException
     */
    public function destroy(int $id): bool
    {
        try {
            DB::beginTransaction();
            $this->deletePivotTechnologies($id);
            $this->deletePivotUsers($id);
            $this->project_repository->getById($id)->delete();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new TransactionFailedException();
        }
        return true;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws TransactionFailedException
     * @throws WorkerNotInThisCompanyException
     */
    public function create(array $data)
    {
        $data = $this->checkWorkerAndCompanyForMatch($data);
        try {
            DB::beginTransaction();
            $project = $this->project_repository->model->create($data);
            $this->addUsersProjects($data, $project->id);
            $this->addProjectsTechnologies($data, $project->id);
            DB::commit();
            return $project;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new TransactionFailedException();
        }

    }

    /**
     * @param float $price
     * @return float[]|int[]
     */
    public function countPriceProjectByDefault(float $price)
    {
        return ["Prepayment" => $price / 5,
            "For project at all" => $price / 5 * 4];
    }


}
