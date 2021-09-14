<?php


namespace App\Services\ModelService;


interface ModelServiceInterface
{

    public function update(int $id, array $data);

    public function destroy(int $id);

    public function create(array $data);

}
