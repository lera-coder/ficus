<?php


namespace App\Repositories\Interfaces;


use App\Models\ApplicantStatus;
use App\Models\Knowledge;

interface RepositoryInterface
{
    public  function all($n);

    public  function getById($id);




}
