<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\DB;

class AllDatas
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $access
     * @return array
     */
    public function all_datas($all_date = [])
    {
        $query_filter = new QueryFilter();
        $get_info_date = new GetInfoDate();

        date_default_timezone_set(env("TIMEZONE"));

        if(count($all_date) === 0){
            $all_date = DB::
            connection("mysql_time")
                ->select("SHOW TABLES");

            $all_date = $query_filter->query_filter($all_date, env("DB_NAME_TIME"));
        }

        $array_datas = [];

        foreach($all_date as $date){

            $date_format = explode("_", $date);
            $date_format = implode(".", $date_format);
            $array_datas[] = [
                "date" => $date_format,
                "data" => $get_info_date->get_data($date)
            ];
        }

        return $array_datas;
    }

    public function edit_month($month){
        $query_filter = new QueryFilter();

        $all_tables = DB::
        connection("mysql_time")
            ->select("SHOW TABLES");

        
        date_default_timezone_set(env("TIMEZONE"));

        $all_tables = $query_filter->query_filter($all_tables, env("DB_NAME_TIME"));
        $array_year = [];

        $year = date("Y");
        foreach($all_tables as $table){
            if(strpos($table, $year)){
                $data_check = explode("_", $table);
                if($data_check[1] === $month){
                    $array_year[] = $table;
                }
            }
        }

        return $array_year;
    }

    public function edit_year($year){
        $query_filter = new QueryFilter();
        
        date_default_timezone_set(env("TIMEZONE"));

        $all_tables = DB::
        connection("mysql_time")
            ->select("SHOW TABLES");

        $all_tables = $query_filter->query_filter($all_tables, env("DB_NAME_TIME"));
        $array_year = [];

        foreach($all_tables as $table){
            $data_check = explode("_", $table);
            if($data_check[2] === $year){
                $array_year[] = $table;
            }
        }

        return $array_year;
    }
}
