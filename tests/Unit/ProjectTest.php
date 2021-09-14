<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Worker;
use App\Repositories\ProjectRepository;
use App\Repositories\WorkerRepository;
use App\Services\ModelService\ProjectService\ProjectService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use DatabaseTransactions;


    public function test_Price()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);

        for ($i = 10; $i < 500; $i += 20) {
            $this->callProjectCalculatePrice($i, $project_service);
        }
    }


    public function callProjectCalculatePrice($price, $project_service)
    {
        $response = $project_service->countPriceProjectByDefault($price);
        $this->assertIsArray($response) &&
        $this->assertEquals(["Prepayment" => $price / 5, "For project at all" => $price / 5 * 4], $response);
    }

    public function test_delete()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);
        $project = Project::find(8);
        $project_service->destroy(8);
        $this->assertDeleted($project);
    }

    public function test_create()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);

        $data = [
            "name" => "allala",
            "users" => [
                1, 2
            ],
            "technologies" => [
                1, 2
            ],
            "company_id" => 9,
            "worker_id" => 1
        ];

        $project = $project_service->create($data);

        $this->assertingUpdateCreateResult($project, $data);
        $this->checkForExistenceInDatabase($data);
        $this->check_for_pivot_table($data, 'users', $project, 'users_projects');
        $this->check_for_pivot_table($data, 'technologies', $project, 'projects_technologies');

    }

    protected function checkForExistenceInDatabase($data){
        $this->assertDatabaseHas('projects', array_diff_key($data, ["users" => 1, "technologies" => 1]));
    }

    protected function check_for_pivot_table($array, $array_el_name, $model, $table_name)
    {
        if (isset($model[$array_el_name])) {
            foreach ($array[$array_el_name] as $el_id) {
                $this->assertDatabaseHas($table_name, [
                    Str::singular($array_el_name) . '_id' => $el_id,
                    "project_id" => $model->id
                ]);
            }
        }
    }

    protected function assertingUpdateCreateResult($project, $data){
        $this->assertEquals(array_intersect_key($project->toArray(), $data),
            array_diff_key($data, ["users" => 1, "technologies" => 1]));
    }

    public function test_update()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);

        $project_id = 3;

        $data = [
            "name" => "allala1",
            "users" => [
                1, 2
            ],
            "technologies" => [
                1, 2
            ],

            "company_id" => 9,
            "worker_id" => 1
        ];

        $project = $project_service->update($project_id, $data);

        $this->assertingUpdateCreateResult($project, $data);
        $this->checkForExistenceInDatabase($data);
        $this->check_for_pivot_table($data, 'users', $project, 'users_projects');
        $this->check_for_pivot_table($data, 'technologies', $project, 'projects_technologies');

    }



}
