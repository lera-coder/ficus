<?php


namespace App\Repositories\Interfaces;


interface PhoneRepositoryInterface extends RepositoryInterface
{
    public function activePhone($user_id);

    public function user($id);

    public function phoneCountryCode($id);
}