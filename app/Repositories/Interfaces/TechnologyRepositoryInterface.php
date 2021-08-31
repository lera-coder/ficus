<?php


namespace App\Repositories\Interfaces;

interface TechnologyRepositoryInterface extends RepositoryInterface
{
    public function knowledges($id);

    public function projects($id);

}
