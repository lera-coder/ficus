<?php


namespace App\Services\ModelService;


use App\Repositories\Interfaces\UserRepositoryInterface;

interface ModelServiceInterface
{

    public function update($id, $data);

    public function destroy($id);


}
