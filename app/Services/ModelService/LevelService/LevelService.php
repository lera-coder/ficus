<?php


namespace App\Services\ModelService\LevelService;


use App\Repositories\Interfaces\LevelRepositoryInterface;

class LevelService implements LevelServiceInterface
{
    protected $level_repository;

    public function __construct(LevelRepositoryInterface $level_repository)
    {
        $this->level_repository = $level_repository;
    }

    public function update($id, $data)
    {
        return $this->level_repository->getById($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->level_repository->getById($id)->destroy();
    }

    public function create($data){
        return $this->level_repository->level->create($data);
    }
}
