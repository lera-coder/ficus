<?php


namespace App\Repositories\Interfaces;

interface ApplicantRepositoryInterface extends RepositoryInterface
{
    public  function status(int $id);

    public  function knowledges(int $id);

    public function interviews(int $id);

    public function getIdsOfApplicantsWithValidStatus();
}
