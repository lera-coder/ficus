<?php


namespace App\Services\ModelService\InterviewService;


use App\Repositories\Interfaces\InterviewRepositoryInterface;

class InterviewService implements InterviewServiceInterface
{
    protected $interview_repository;

    public function __construct(InterviewRepositoryInterface $interview_repository)
    {
        $this->interview_repository = $interview_repository;
    }

    public function update($id, $data)
    {
        return $this->interview_repository->getById($id)
            ->update($data);
    }

    public function destroy($id)
    {
        return $this->interview_repository->getById($id)->destroy();
    }

    public function create($data)
    {
        return $this->interview_repository->interview->create($data);
    }
}
