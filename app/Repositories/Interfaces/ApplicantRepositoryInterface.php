<?php


namespace App\Repositories\Interfaces;


use App\Models\Applicant;

interface ApplicantRepositoryInterface extends RepositoryInterface
{
    public static  function status(Applicant $applicant);

    public static  function knowledges(Applicant $applicant);

}
