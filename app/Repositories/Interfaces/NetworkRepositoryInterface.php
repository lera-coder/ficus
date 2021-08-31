<?php


namespace App\Repositories\Interfaces;


interface NetworkRepositoryInterface extends RepositoryInterface
{
    public function users($id);

    public function getModelByName($name);

    public function checkSocialNetworkForExistance($network);

    }


