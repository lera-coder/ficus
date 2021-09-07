<?php

namespace App\Services\ModelService\InterviewService;

use App\Exceptions\SendingTimeIsBiggerThanInterviewTimeException;
use App\Exceptions\TransactionFailedException;
use App\Exceptions\TryToPublishEmptyException;
use App\Exceptions\UnsuccessfullDeleteException;
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
        $this->checkInterviewForValidTimeUpdate($id, $data);

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
     * @param $id
     * @param $data
     * @throws SendingTimeIsBiggerThanInterviewTimeException
     */
    protected function checkInterviewForValidTimeUpdate($id, $data)
    {
        $interview = $this->interview_repository->getById($id);

        $sending_time = array_key_exists('sending_time', $data)
            ? $data['sending_time']
            : $interview->sending_time;

        $interview_time = array_key_exists('interview_time', $data)
            ? $data['interview_time']
            : $interview->interview_time;

        if((($sending_time != null) && ($interview_time == null)) || ((gettype($sending_time) == gettype($interview_time))
                &&(!gettype($sending_time) ==  null) && ($sending_time < $interview_time))){
            throw new SendingTimeIsBiggerThanInterviewTimeException();
        }
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
        try {
            $this->interview_repository->getById($id)->delete();
        } catch (Exception $e) {
            throw new UnsuccessfullDeleteException();
        }
    }

    /**
     * @param $interview_id
     * @param $applicant_id
     * @throws UnsuccessfullDeleteException
     */
    public function deleteApplicantFromInterview($interview_id, $applicant_id){
        try {
            $field_id = DB::table('applicants_interviews')
                ->where('applicant_id', $applicant_id)
                ->where('interview_id', $interview_id)
                ->delete();
        }
        catch (Exception $e){
            throw new UnsuccessfullDeleteException();
        }

    }


    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $interview = (key_exists('status_id', $data) && $data['status_id'] == 2) ?
            $this->checkCreateInterviewForPublishStatus($data) :
            $this->interview_repository->model->create($data);
        $this->fillPivotApplicantTable($interview->id, $data['applicants']);
    }

    /**
     * Function to check if this interview is filled for publishing
     * @param $data
     * @return mixed
     */
    protected function checkCreateInterviewForPublishStatus($data)
    {
        if (($this->checkDataKeyForNullableAndExistance($data, 'link')) &&
            ($this->checkDataKeyForNullableAndExistance($data, 'interview_time')) &&
            ($this->checkDataKeyForNullableAndExistance($data, 'sending_time')) &&
            ($this->checkDataKeyForNullableAndExistance($data, 'interviewer_id'))) {

            return $this->interview_repository->model->create($data);
        }

        throw new TryToPublishEmptyException
        ('To publish interview  you should fill fields:' .
            'link, interview time, sending time, interviewer');
    }


    /**
     * @param $data
     * @param $key
     * @return bool
     */
    private function checkDataKeyForNullableAndExistance($data, $key)
    {
        return key_exists($key, $data) && is_null($data[$key]);
    }

    public function makeValidFiltrationArray($request_array){
        dd($request_array);
    }


}
