<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProjectAppTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_projects_index($route = 'api/projects')
    {
        $response = $this->get($route);
        $response->assertOk();

        $paginator = $response->getOriginalContent();

        //Asserting getting all raws from table
        $this->assertEquals(DB::table('projects')->count(), $paginator->total());

        //Asserting right quantity of products on each page
        $response->assertJsonCount($paginator->lastPage() != $paginator->currentPage()?
            $paginator->perPage():
            $paginator->total() - (($paginator->currentPage() - 1) * $paginator->perPage()), 'data');

        //Asserting that it's a collection of projects
        foreach($paginator->items() as $project){
            $this->assertInstanceOf(Project::class, $project);
        }

        //Recursion call to next page
        if(!is_null($paginator->nextPAgeUrl())){
            $this->test_projects_index(str_replace(Config::get('app.url'),
                '', $paginator->nextPAgeUrl()));
        }
    }


}
