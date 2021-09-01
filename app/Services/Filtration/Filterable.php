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
    public function getArray($route, $keys){
        $result_array = [];
        $array = explode('&', $route);
        foreach ($array as $element){
            $exploded_element = explode('=', $element);
            $result_array[$exploded_element[0]] = explode('_', $exploded_element[1]);
        }
        $result_array = $this->checkKeys($result_array, $keys);
        return $result_array;
    }


    /**
     * @param $array
     * @param $keys
     * @return array
     */
    protected function checkKeys($array, $keys){
        $result_array = [];
        foreach ($array as $key=>$value){
            if(in_array($key, $keys)) {
                $result_array[$key] = $value;
            }
        }
        return $result_array;
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
