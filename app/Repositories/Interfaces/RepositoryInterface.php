<?php


namespace App\Repositories\Interfaces;


use App\Models\ApplicantStatus;
use App\Models\Knowledge;

interface RepositoryInterface
{
    public  function all(int $n);

    public  function getById(int $id);




}
