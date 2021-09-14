<?php


namespace App\Repositories\Interfaces;


interface PhoneCountryCodeRepositoryInterface extends RepositoryInterface
{
    public function phones(int $id);

    public function users(int $id);

    public function getIdByCode($code);

}
