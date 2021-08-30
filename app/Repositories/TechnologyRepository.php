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

    public static function knowledges(Technology $technology){
        return $technology->knowledges();
    }

    public static function projects(Technology $technology){
        return $technology->projects;
    }


}
