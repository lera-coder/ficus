<?php


namespace App\Repositories\Interfaces;


use App\Models\Technology;

interface TechnologyRepositoryInterface extends RepositoryInterface
{
    public static function knowledges(Technology $technology);

    public static function projects(Technology $technology);

}
