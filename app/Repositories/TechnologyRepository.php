<?php


namespace App\Repositories;


use App\Models\Technology;
use App\Repositories\Interfaces\TechnologyRepositoryInterface;

class TechnologyRepository implements TechnologyRepositoryInterface
{
    protected $technology;

    public function __construct(Technology $technology)
    {
        $this->technology = $technology;
    }

    public function all($n)
    {
        return $this->technology->paginate($n);
    }

    public function getById($id)
    {
        return $this->technology->findOrFail($id);
    }

    public function knowledges($id){
        return $this->getById($id)->knowledges;
    }

    public function projects($id){
        return $this->getById($id)->projects;
    }


}
