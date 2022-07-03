<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\Logging;
use App\Http\Middleware\ReturnRequest;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return string
     */
    public function check_date(Request $request)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        date_default_timezone_set(env("TIMEZONE"));

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Охранник") !== true){
            return $check_role->role_check($request);
        }

        $active_date = date("d_m_Y");
        $mysql = DB::connection("mysql_time")->select("SHOW TABLES LIKE '$active_date';");

        if(count($mysql) === 0){
            $logging->add_log_user("Открыта новая смена", "work-shift-times.log");

            Schema::connection("mysql_time")
                ->create($active_date, function(Blueprint $table) {
                    $table->id();
                    $table->integer("user_id");
                    $table->string("time");
                    $table->timestamps();
                });
        }

        $logging->add_log_ip("был активирован запрос", "work-shift-times.log");

        return $return_request->return_request([
            "Смена активирована"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function user_verify(Request $request, $hash)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        date_default_timezone_set(env("TIMEZONE"));
        $active_date = date("d_m_Y");
        $active_time = date("H:i:s");

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request) !== true){
            return $check_role->role_check($request);
        }

        $user = User::where("qr_token", $hash)->get();
        $id = $user[0]->id;

        if(count($user) === 0){

            $logging->add_log_ip("была совершена неудачная попытка авторизации", "work-shift-times.log");
            $logging->add_log_user("Пользователь не авторизовался по QR коду", "work-shift-times.log");

            return $return_request->return_request([
                "user_data" => "Пользователь не найден"
            ], 404);
        }

        DB::connection("mysql_time")
            ->table($active_date)
            ->insert([
                "user_id" => $id,
                "time" => $active_time
            ]);

        $login = $user[0]->login;
        $logging->add_log_ip("была совершена успешная авторизация", "work-shift-times.log");
        $logging->add_log_user("Пользователь $login авторизовался по QR коду", "work-shift-times.log");

        return $return_request->return_request([
            "user_data" => "Пользователь авторизован"
        ], 200);
    }
}
