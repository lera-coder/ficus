<?php


namespace App\Repositories\Interfaces;


use App\Models\Level;

interface LevelRepositoryInterface extends RepositoryInterface
{
    public function knowledges(Level $level);

}
