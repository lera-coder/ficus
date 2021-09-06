<?php


namespace App\Services\ModelService\TechnologyService;


use App\Repositories\Interfaces\TechnologyRepositoryInterface;

class TechnologyService implements TechnologyServiceInterface
{
    protected $technology_repository;

    public function __construct(TechnologyRepositoryInterface $technology_repository)
    {
        $this->technology_repository = $technology_repository;
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        return $this->technology_repository->getById($id)->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->technology_repository->getById($id)->destroy();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->technology_repository->technology->create($data);
    }
}
