<?php


namespace App\Repositories\Interfaces;


interface InterviewStatusRepositoryInterface extends RepositoryInterface
{
    public function getIdByName(string$status_name);

    public function getAllIds();

    public function getIdsForFiltration(array $statuses_array);
}
