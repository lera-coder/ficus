<?php


namespace App\Services\ModelService;


interface ModelServiceInterface
{

    public function update($id, $data);

    public function destroy($id);

    public function create($data);

}
