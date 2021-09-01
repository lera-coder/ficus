<?php


namespace App\Repositories\Interfaces;


interface InterviewRepositoryInterface extends RepositoryInterface
{
    public function applicants($id);

    public function getByStatuses($statuses);

    public function getByApplicant($id);

    public function getByInterviewer($interviewer_id);

    public function filtration($request_array);

}