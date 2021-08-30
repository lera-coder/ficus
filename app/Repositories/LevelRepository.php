<?php


namespace App\Repositories;


use App\Models\Level;
use App\Repositories\Interfaces\LevelRepositoryInterface;

class LevelRepository implements LevelRepositoryInterface
{
    public $level;

    public function __construct(Level $level)
    {
        $this->level = $level;
    }

    public function all($n)
    {
        return $this->level->paginate($n);
    }

    public function getById($id)
    {
        return $this->level->findOrFail($id);
    }

    public function knowledges($id){
        return $this->getById($id)->knowledges;
    }

}
