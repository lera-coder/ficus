<?php


namespace App\Repositories\Interfaces;


interface InterviewRepositoryInterface extends RepositoryInterface
{
    public function applicants($id);

}
