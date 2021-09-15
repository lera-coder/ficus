<?php

namespace App\Services\ModelService\InterviewService;

use App\Exceptions\SendingTimeIsBiggerThanInterviewTimeException;
use App\Exceptions\TransactionFailedException;
use App\Exceptions\TryToPublishEmptyException;
use App\Exceptions\UnsuccessfullDeleteException;
use App\Repositories\Interfaces\InterviewRepositoryInterface;
use App\Repositories\Interfaces\InterviewStatusRepositoryInterface;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;


class InterviewService implements InterviewServiceInterface
{
    protected $interview_repository;
    protected $interview_statuses_repository;

    public function __construct(InterviewRepositoryInterface $interview_repository,
                                InterviewStatusRepositoryInterface $interview_statuses_repository)
    {
        $this->interview_repository = $interview_repository;
        $this->interview_statuses_repository = $interview_statuses_repository;
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

        if ((($sending_time != null) && ($interview_time == null)) || ((gettype($sending_time) == gettype($interview_time))
                && (!gettype($sending_time) == null) && ($sending_time < $interview_time))) {
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
    public function deleteApplicantFromInterview($interview_id, $applicant_id)
    {
        try {
            DB::table('applicants_interviews')
                ->where('applicant_id', $applicant_id)
                ->where('interview_id', $interview_id)
                ->delete();
        } catch (Exception $e) {
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

    /**
     * @param $request_array
     * @return array
     */
    public function makeValidFiltrationArray($request_array): array
    {
        if (array_key_exists('statuses', $request_array))
            $request_array['statuses'] = $this->getValidStatusesArray($request_array['statuses']);
        if (array_key_exists('interviewers', $request_array))
            $request_array['interviewers'] = $this->getValidArrayFromKeysString($request_array['interviewers']);
        if (array_key_exists('applicants', $request_array))
            $request_array['applicants'] = $this->getValidArrayFromKeysString($request_array['applicants']);
        if (array_key_exists('interview-dates', $request_array))
            $request_array['interview-dates'] = $this->getValidInterviewDateArray($request_array['interview-dates']);
        if (array_key_exists('sort', $request_array)) {
            $request_array['sort'] = $this->getValidSortArray($request_array['sort']);
        }

        return $request_array;
    }

    /**
     * @param string $statuses
     * @return array
     */
    public function getValidStatusesArray(string $statuses): array
    {
        $statuses = explode('_', $statuses);
        return $this->interview_statuses_repository->getIdsForFiltration($statuses);
    }

    /**
     * @param string $request_string_keys
     * @return array
     */
    public function getValidArrayFromKeysString(string $request_string_keys): array
    {
        return explode('_', $request_string_keys);
    }

    /**
     * @param string $dates
     * @return array[]
     */
    public function getValidInterviewDateArray(string $dates): array
    {
        $dates_array = explode('_', $dates);
        $dates_between = [];
        $dates_in = [];

        foreach ($dates_array as $date) {
            if (str_contains($date, '|')) {
                array_push($dates_between, $this->convertArrayToDateTime(explode('|', $date)));
            } else {
                array_push($dates_in, $this->convertStringToDateTime($date));
            }
        }
        return array('dates_between' => $dates_between, 'dates_in' => $dates_in);
    }

    /**
     * @param array $date
     * @return array
     */
    protected function convertArrayToDateTime(array $date)
    {
        $date[0] = $this->convertStringToDateTime($date[0]);
        $date[1] = $this->convertStringToDateTime($date[1]);
        return $date;
    }

    /**
     * @param string $date
     * @return string
     * @throws Exception
     */
    protected function convertStringToDateTime(string $date)
    {
        return new DateTime($date);
    }

    public function getValidSortArray(string $sort_string)
    {
        $sort_variants = ["interview-date" => "interview_time", "applicants" => "name", "interviewers" => "interviewer_id"];
        $sort_result = [];
        if (str_contains('_', $sort_string)) {
            $sort_array = explode('_', $sort_string);
            $sort_result[1] = $sort_array[1];
            $sort_result[0] = $sort_variants[$sort_array[0]];
        } else {
            $sort_result[0] = $sort_variants[$sort_string];
            $sort_result[1] = 'asc';
        }
        return $sort_result;


    }


}
