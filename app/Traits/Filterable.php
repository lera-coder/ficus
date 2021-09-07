<?php


namespace App\Traits;


use App\Models\Interview;
use DateInterval;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;

trait Filterable
{

    /**
     * @param $result_data
     * @param $request_data
     * @param $field_name
     * @param $column_name
     * @return mixed
     */
    public function filtrationWhereInByKeys($result_data, $request_data, $field_name, $column_name)
    {
        if (key_exists($field_name, $request_data)) {
            return $result_data->whereIn($column_name, $request_data[$field_name]);
        }
        return $result_data;
    }


    /**
     * @param $result_data
     * @param $converted_data
     * @param $column_name_in_db
     * @return mixed
     */
    public function filtrationWithConvertedData($result_data,
                                                $converted_data,
                                                $column_name_in_db)
    {
            return $result_data->whereIn($column_name_in_db, $converted_data);
    }


    /**
     * @param $result
     * @param $request_array
     * @return mixed
     */
    public function filtrationByTimeBetween($result_data, $request_data, $field_name, $column_name)
    {
        if (key_exists($field_name, $request_data)) {
            $array_time_between = $this->getArrayTimeBetween($request_data[$column_name]);
            $date_result = collect();
            foreach ($array_time_between as $date) {
                $date = explode('|', $date);
                $date = $this->renovateDate($date);
                $date_result = $result_data->whereBetween($column_name, $date)->union($date_result);
            }
            return $date_result;
        }
        return $result_data;
    }



    /**
     * @param $request_array
     * @return array
     */
    protected function getArrayTimeBetween($request_array)
    {
        return array_filter($request_array, function ($value) {
            return str_contains($value, '|');
        });
    }


    /**
     * This function is for adding one day to last day of range
     * It's for making not absolute boundary
     * @param $date
     * @return mixed
     * @throws Exception
     */
    protected function renovateDate($date)
    {
        $date[1] = new DateTime($date[1]);
        $date[1]->add(new DateInterval('P1D'));
        $date[1] = $date[1]->format('Y-m-d');
        return $date;
    }




}