<?php

namespace App\Services\ModelService\InterviewService;

use App\Exceptions\TransactionFailedException;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;


class InterviewService implements InterviewServiceInterface
{
    protected $interview_repository;

    public function __construct(InterviewRepositoryInterface $interview_repository)
    {
        $this->interview_repository = $interview_repository;
    }


    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function update($id, $data)
    {
        $interview = $this->interview_repository->getById($id);

        try {
            DB::beginTransaction();
            $this->fillPivotApplicantTable($interview->id, $data['applicants']);
            $interview->update($data);
            $interview->push();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw(new TransactionFailedException());
        }

        return $interview;
    }


    /**
     * @param $interview_id
     * @param $applicants_ids
     */
    protected function fillPivotApplicantTable($interview_id, $applicants_ids)
    {
        foreach ($applicants_ids as $applicant_id) {
            DB::table('applicants_interviews')->insert([
                'applicant_id' => $applicant_id,
                'interview_id' => $interview_id
            ]);
        }
    }


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->interview_repository->getById($id)->destroy();
    }


    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->interview_repository->interview->create($data);
    }


}
