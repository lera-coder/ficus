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

    /**
     * @param $n
     * @return mixed
     */
    public function all($n)
    {
        return $this->level->query()->paginate($n);
    }

    /**
     * @param Level $id
     * @return mixed
     */
    public function knowledges($id)
    {
        return $this->getById($id)->knowledges;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->level->query()->findOrFail($id);
    }

}
