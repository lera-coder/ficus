<?php


namespace App\Repositories\Interfaces;


interface WorkerRepositoryInterface extends RepositoryInterface
{
    public function emails($id);

    public function phones($id);

    public function position($id);

    public function status($id);

    public function company($id);

    public function projects($id);

}
