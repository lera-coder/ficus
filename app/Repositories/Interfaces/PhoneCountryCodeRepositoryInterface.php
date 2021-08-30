<?php


namespace App\Repositories\Interfaces;


interface PhoneCountryCodeRepositoryInterface extends RepositoryInterface
{
    public function phones($id);

    public function users($id);

    public function getIdByCode($code);

}
