<?php


namespace App\Repositories\Interfaces;


interface InterviewRepositoryInterface extends RepositoryInterface
{
    public function applicants(int $id);

    public function getByStatuses(array $statuses);

    public function getByApplicant(int $applicant_id);

    public function getByInterviewer(int $interviewer_id);

    public function filtration(array $request_array);

    public function status(int $status_id);

    public function interviewer(int $interviewer_id);


}
