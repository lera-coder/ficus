<?php


namespace App\Repositories\Interfaces;


interface NetworkRepositoryInterface extends RepositoryInterface
{
    public function users(int $id);

    public function getModelByName(string $name);

    public function checkSocialNetworkForExistence(string $network);

    }


