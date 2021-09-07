<?php

namespace App\Http\Resources\InterviewResources;

use App\Repositories\Interfaces\InterviewRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;

class InterviewFullResource extends JsonResource
{
    protected $interview_repository;

    public function __construct($resource)
    {
        $this->interview_repository = App::make(InterviewRepositoryInterface::class);
        parent::__construct($resource);

    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "link"=>$this->link,
            "description"=>$this->description,
            "interview_time"=>$this->interview_time,
            "sending_time"=>$this->sending_time,
            "status"=>$this->interview_repository->status($this->id),
            "applicants"=>$this->interview_repository->applicants($this->id),
            "interviewer"=>$this->interview_repository->interviewer($this->id)
        ];
    }
}
