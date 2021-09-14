<?php


namespace App\Repositories\Interfaces;


interface PhoneRepositoryInterface extends RepositoryInterface
{
    public function activePhone(int $user_id);

    public function user(int $id);

    public function phoneCountryCode(int $id);
}
