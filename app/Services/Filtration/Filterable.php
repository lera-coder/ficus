<?php


namespace App\Services\Filtration;


use DateTime;

trait Filterable
{

    /**
     * @param $route
     * @param $keys
     * @return array
     */
    public function getArray($filtration_values_keys_array, $fields){
        return array_map(function ($values){
            return explode('_', $values);
        }, $filtration_values_keys_array);
    }



    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    protected function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }


    /**
     * @param $first_date
     * @param $second_date
     * @return bool
     */
    protected function checkDateIsEarlier($first_date, $second_date){
        return $first_date < $second_date;
    }



}
