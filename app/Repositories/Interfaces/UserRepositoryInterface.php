<?php


namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function emails(int $id);

    public function phones(int $id);

    public function activePhone(int $id);

    public function disactivePhones(int $id);

    public function disactiveEmails(int $id);

    public function activeEmail(int $id);

    public function getFullActivePhone(int $id);

    public function network(int $id);

    public function token2fa(int $id);

    public function roles(int $id);

    public function getIdViaLogin(string $login);

    public function getInterviewerIds();

    public function search($query);


    }
