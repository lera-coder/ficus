<?php


namespace App\Repositories\Interfaces;


use App\Models\ApplicantStatus;

interface ApplicantStatusRepositoryInterface extends RepositoryInterface
{
    public static function applicants(ApplicantStatus $applicant_status);

}
