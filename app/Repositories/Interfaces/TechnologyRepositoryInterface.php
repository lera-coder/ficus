<?php


namespace App\Repositories\Interfaces;

interface TechnologyRepositoryInterface extends RepositoryInterface
{
    public function knowledges(int $id);

    public function projects(int $id);

}
