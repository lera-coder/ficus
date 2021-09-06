<?php


namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function emails($id);

    public function phones($id);

    public function activePhone($id);

    public function disactivePhones($id);

    public function disactiveEmails($id);

    public function activeEmail($id);

    public function getFullActivePhone($id);

    public function network($id);

    public function token2fa($id);

    public function roles($id);

    public function getIdViaLogin($login);

    public function getInterviewerIds();




    }
