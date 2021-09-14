<?php


namespace App\Repositories\Interfaces;


interface KnowledgeRepositoryInterface extends RepositoryInterface
{

    public function knowledgable(int $id);

    public function technology(int $id);

    public function level(int $id);

    public function knowledgeWithThisTechnologyAndKnowledgableType(int $technology_id, int $knowledge_id);
}
