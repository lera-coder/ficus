<?php


namespace App\Repositories\Interfaces;


use App\Models\Network;

interface NetworkRepositoryInterface extends RepositoryInterface
{
    public static function users(Network $network);

    public function getModelByName($name);

    public function checkSocialNetworkForExistance($network);

    }


