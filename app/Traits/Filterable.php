<?php


namespace App\Traits;

use DateInterval;
use Exception;
use Illuminate\Database\Query\Builder;
use \Illuminate\Contracts\Pagination\LengthAwarePaginator;
trait Filterable
{

    /**
     * @param Builder $result_query
     * @param array $request_data
     * @param string $field_name
     * @param string $column_name
     * @return Builder
     */
    public function filtrationWhereInByKeys(Builder $result_query,
                                            array $request_data,
                                            string $field_name,
                                            string $column_name): Builder
    {
        return $result_query->when(isset($request_data[$field_name]),
            function ($query) use ($request_data, $column_name, $field_name) {
                return $query->whereIn($column_name, $request_data[$field_name]);
            });
    }


    /**
     * @param $result
     * @param $request_array
     * @return Builder
     */
    public function filtrationByDates(Builder $result_query,
                                      array $request_data,
                                      string $dates_between_field_name,
                                      string $column_name,
                                      string $dates_in_field_name):Builder
    {

        $is_between_dates = false;
        if (key_exists($dates_between_field_name, $request_data)) {
            $is_between_dates = true;

            $date = $this->renovateDate($request_data[$dates_between_field_name][0]);
            $result_query = $result_query->whereBetween($column_name, $date);

            foreach (array_slice($request_data[$dates_between_field_name], 1) as $date) {
                $date = $this->renovateDate($date);
                $result_query = $result_query->orWhereBetween($column_name, $date);
            }
        }
        if(key_exists($dates_in_field_name, $request_data)){

            if($is_between_dates){
                $result_query = $result_query->orWhereDate($column_name, $request_data[$dates_in_field_name][0]);
            }
            else{
                return $result_query->WhereDate($column_name, $request_data[$dates_in_field_name][0]);
            }

            foreach (array_slice($request_data[$dates_in_field_name], 1) as $date){
                $result_query = $result_query->orWhereDate($column_name, $date);
            }
        }


        return $result_query;
    }




    /**
     * This function is for adding one day to last day of range
     * It's for making not absolute boundary
     * @param array $date
     * @return array
     * @throws Exception
     */
    protected function renovateDate(array $date):array
    {
        $date[1]->add(new DateInterval('P1D'));
        return $date;
    }


    /**
     * @param array $request_data
     * @param Builder $result_query
     * @return LengthAwarePaginator
     */
    public function paginate(array $request_data, Builder $result_query): LengthAwarePaginator
    {
        if(array_key_exists('per_page', $request_data)){
            return $result_query->paginate($request_data['per_page']);
        }
        return $result_query->paginate(10);
    }

    /**
     * @param array $request_data
     * @param Builder $result_query
     * @return Builder
     */
    public function sort(array $request_data, Builder $result_query):Builder{
        return $result_query->orderBy($request_data['sort'][0], $request_data['sort'][1]);
    }


}