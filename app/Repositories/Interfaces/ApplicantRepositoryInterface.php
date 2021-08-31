<?php


namespace App\Repositories\Interfaces;

interface ApplicantRepositoryInterface extends RepositoryInterface
{
    public  function status($id);

    public  function knowledges($id);

}
