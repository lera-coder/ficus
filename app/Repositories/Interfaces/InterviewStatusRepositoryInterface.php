<?php


namespace App\Repositories\Interfaces;


interface InterviewStatusRepositoryInterface extends RepositoryInterface
{
    public function getIdByName($status_name);
}
