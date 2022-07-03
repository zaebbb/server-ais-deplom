<?php

namespace App\Http\Middleware;

use App\Models\Enclosures;
use App\Models\Posts;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\DB;

class GetInfoDate
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param false|string $active_date
     * @return array
     */
    public function get_data($active_date = "")
    {
        $query_filter = new QueryFilter();
        
        date_default_timezone_set(env("TIMEZONE"));

        if(empty($active_date)){
            $active_date = date("d_m_Y");
        }

        $show_all_datas = DB::connection("mysql_time")
            ->select("SHOW TABLES");

        $show_all_datas = $query_filter->query_filter($show_all_datas, env("DB_NAME_TIME"));

        if(!in_array($active_date, $show_all_datas, true)){
            $active_date = date("d_m_Y");
        }

        $query_filter = new QueryFilter();

        $data_users = DB::connection("mysql_time")
            ->table($active_date)
            ->select("user_id", "time")
            ->get();

        $filter_users_id = array_unique($query_filter->query_filter($data_users, "user_id"));

        $users = User::
        whereIn("id", $filter_users_id)
            ->get();

        $users_infos = UserInfo::
        whereIn("id", $filter_users_id)
            ->get();

        $result_table = [];

        $counter = 0;
        while($counter < count($users)){
            $roles = Roles::
            leftJoin("user_roles", "user_roles.role_id", "=", "roles.id")
                ->where("user_roles.user_id", $users[$counter]->id)
                ->get()
                ->map(function($item){ return $item->role; });

            $enclosures = Enclosures::
            leftJoin("user_corpuses", "user_corpuses.corpus_id", "=", "enclosures.id")
                ->where("user_corpuses.user_id", $users[$counter]->id)
                ->get()
                ->map(function($item){ return $item->corpus; });

            $posts = Posts::
            leftJoin("user_posts", "user_posts.post_id", "=", "posts.id")
                ->where("user_posts.user_id", $users[$counter]->id)
                ->get()
                ->map(function($item){ return $item->post; });


            $result_time = [];
            foreach($data_users as $time_data){
                if($time_data->user_id === $users[$counter]->id){
                    $result_time[] = $time_data->time;
                }
            }

            $work_time = 0;
            $is_night_work = false;
            for($i = 0; $i < count($result_time);$i++){
                if($i % 2 === 0){
                    if(!empty($result_time[$i + 1])){
                        $time_start = explode(":", $result_time[$i]);
                        $time_end = explode(":", $result_time[$i + 1]);

                        $start_filter = $time_start[0] * 60 * 60 + $time_start[1] * 60 + $time_start[2];
                        $end_filter = $time_end[0] * 60 * 60 + $time_end[1] * 60 + $time_end[2];

                        $work_time += $end_filter - $start_filter;
                    } else {
                        $is_night_work = true;
                    }
                }
            }
            $hours = floor($work_time / 60 / 60);
            $minutes = round(($work_time - $hours * 3600) / 60);

            $work_result = "Часов: " . floor($hours) . "; минут: " . $minutes . ";";

            if($is_night_work){ $work_result .= " + ночная смена"; }

            $result_table[] = [
                "login" => $users[$counter]->login,
                "name" => $users_infos[$counter]->name,
                "surname" => $users_infos[$counter]->surname,
                "patronymic" => $users_infos[$counter]->patronymic,
                "roles" => $roles,
                "enclosures" => $enclosures,
                "posts" => $posts,
                "time" => $result_time,
                "work_time" => $work_result
            ];
            $counter++;
        }

        return $result_table;
    }

    public function check_is_date($date){
        $query_filter = new QueryFilter();

        date_default_timezone_set(env("TIMEZONE"));

        $show_all_datas = DB::connection("mysql_time")
            ->select("SHOW TABLES");

        $show_all_datas = $query_filter->query_filter($show_all_datas, env("DB_NAME_TIME"));

        if(in_array($date, $show_all_datas, true)){
            return true;
        }

        return false;
    }
}



// сначала перекуидываешь из папки zip папку woocommerce в обычную а то в filezilla не смогешь перекинуть, потом заходишь в filezillf в папку с названием сайта, и дальше уже все внтрь до папки plugins