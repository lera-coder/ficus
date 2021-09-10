<?php


namespace App\Repositories\Interfaces;


interface InterviewRepositoryInterface extends RepositoryInterface
{
    public function applicants($id);

    public function getByStatuses($statuses);

    public function getByApplicant($id);

    public function getByInterviewer($interviewer_id);

    public function filtration(array $request_array);

    public function status($id);

    public function interviewer($id);


}
