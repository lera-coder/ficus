<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateKnowledgeRequest;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateKnowledgeRequest;
use App\Models\Knowledge;
use App\Repositories\Interfaces\KnowledgeRepositoryInterface;
use App\Services\ModelService\KnowledgeService\KnowledgeServiceInterface;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    protected $knowledge_repository;
    protected $knowledge_service;

    public function __construct(KnowledgeRepositoryInterface $knowledge_repository,
                                KnowledgeServiceInterface $knowledge_service)
    {
        $this->knowledge_repository = $knowledge_repository;
        $this->knowledge_service = $knowledge_service;
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->knowledge_repository->all(50);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateKnowledgeRequest $request)
    {
        return $this->knowledge_service->create($request->only(
            ["year_start", "description", "knowledgable_type", "knowledgable_id", "technology_id", "level_id"]));
    }

    /**
     * @param  \App\Models\Technology  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->knowledge_repository->getById($id);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKnowledgeRequest $request, $id)
    {
        return $this->knowledge_service->update($id, $request->only(
            ["year_start", "description", "knowledgable_type", "knowledgable_id", "technology_id", "level_id"]));
    }

    /**
     * @param  \App\Models\Technology  $knowledge
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->knowledge_service->destroy($id);
    }
}

