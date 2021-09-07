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

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->level_repository->getById($id)->update($data);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->level_repository->getById($id)->destroy();
    }


    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->level_repository->model->create($data);
    }
}
