<?php


namespace App\Services\Filtration\InterviewFiltrationService;


use App\Services\Filtration\FiltrationInterface;

interface InterviewFiltrationInterface extends FiltrationInterface
{
    public function apply($filtration_values_keys_array, $fields);


}
