<?php


namespace App\Repositories\Interfaces;


interface LevelRepositoryInterface extends RepositoryInterface
{
    public function knowledges(int $level_id);

}
