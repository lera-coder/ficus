<?php


namespace App\Repositories\Interfaces;


interface ApplicantStatusRepositoryInterface extends RepositoryInterface
{
    public function applicants(int $id);

}
