<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AllDatas;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\FormatDocFileData;
use App\Http\Middleware\GetInfoDate;
use App\Http\Middleware\Logging;
use App\Http\Middleware\ReturnRequest;
use App\Http\Middleware\TemplatesSaves;
use App\Models\User;
use Illuminate\Http\Request;

class ViewAllDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function view_data(Request $request)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $word_content = new FormatDocFileData();

        date_default_timezone_set(env("TIMEZONE"));

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $login = $user[0]->login;

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $array_datas = $all_datas->all_datas();

        $logging->add_log_ip("была получена информация о всех сменах", "save-all-data.log");
        $logging->add_log_user("Пользователь $login получил доступ ко всем сменам", "save-all-data.log");

        return $return_request->return_request($array_datas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function view_date_value(Request $request, $date)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $word_content = new FormatDocFileData();
        $get_info_date = new GetInfoDate();

        date_default_timezone_set(env("TIMEZONE"));

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $login = $user[0]->login;

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $datas = $get_info_date->get_data($date);
        $active_date = date("d_m_Y");
        $active_date_format = date("d.m.Y");

        if($get_info_date->check_is_date($date) !== false){
            $date = explode("_", $date);
            $date = implode(".", $date);
        } else {
            $date = $active_date_format;
        }

        $result = [
            [
                "date" => $date,
                "data" => $datas
            ],
        ];

        $logging->add_log_ip("была получена информация о смене $date", "save-all-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со смены $date", "save-all-data.log");

        return $return_request->return_request($result, 200);
    }
}
