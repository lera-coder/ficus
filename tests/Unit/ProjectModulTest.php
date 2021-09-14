<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Worker;
use App\Repositories\ProjectRepository;
use App\Repositories\WorkerRepository;
use App\Services\ModelService\ProjectService\ProjectService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class ProjectModulTest extends TestCase
{
    use DatabaseTransactions;


    public function test_price_200()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);

        $response = $project_service->countPriceProjectByDefault(200);
        $this->assertIsArray($response) &&
        $this->assertEquals(["Prepayment" => 40, "For project at all" => 160], $response);
    }

    public function test_price_100()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);

        $response = $project_service->countPriceProjectByDefault(100);
        $this->assertIsArray($response) &&
        $this->assertEquals(["Prepayment" => 20, "For project at all" => 80], $response);
    }

    public function test_price_400()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);

        $response = $project_service->countPriceProjectByDefault(400);
        $this->assertIsArray($response) &&
        $this->assertEquals(["Prepayment" => 80, "For project at all" => 320], $response);
    }

    public function test_delete_return_right_status()
    {
        $worker_repository = new WorkerRepository(new Worker);
        $project_repository = new ProjectRepository(new Project);
        $project_service = new ProjectService($project_repository, $worker_repository);
        $result = $project_service->destroy(8);
        $this->assertTrue($result);
    }


    public function test_create_return_right_type()
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
        $this->assertInstanceOf(Project::class, $project);
    }

    public function test_create_return_right_result()
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
        $this->assertEquals(array_intersect_key($project->toArray(), $data),
            array_diff_key($data, ["users" => 1, "technologies" => 1]));
    }

    public function test_update_return_right_type()
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
        $this->assertInstanceOf(Project::class, $project);

    }

    public function test_update_return_right_result()
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

        $this->assertEquals(array_intersect_key($project->toArray(), $data),
            array_diff_key($data, ["users" => 1, "technologies" => 1]));
    }

    public function test_index_right_type()
    {
        $project_repository = new ProjectRepository(new Project);
        $all = $project_repository->all(20);
        $this->assertInstanceOf(LengthAwarePaginator::class, $all);
    }

}
