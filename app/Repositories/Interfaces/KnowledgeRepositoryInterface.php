<?php


namespace App\Repositories\Interfaces;


interface KnowledgeRepositoryInterface extends RepositoryInterface
{

    public function knowledgable($id);

    public function technology($id);

    public function level($id);

    public function knowledgeWithThisTechnologyAndKnowledgableType($technology_id, $knowledge_id);
}
