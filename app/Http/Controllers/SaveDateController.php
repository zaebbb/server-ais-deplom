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
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use function Ramsey\Uuid\v4;

class SaveDateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $date
     * @return bool|string
     */
    public function save_html(Request $request, $date)
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

        $html_data = $templates_save->template_html($result);

        $filename = v4() . ".html";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $html_data);

        $logging->add_log_ip("была получена информация о смене $date в формате HTML", "save-all-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со смены $date в формате HTML", "save-all-data.log");

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $date
     * @return bool|string
     */
    public function save_excel(Request $request, $date)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $word_content = new FormatDocFileData();
        $get_info_date = new GetInfoDate();

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

        $html_data = $templates_save->template_excel($result);

        $filename = v4() . ".xls";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о смене $date в формате Excel", "save-all-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со смены $date в формате Excel", "save-all-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $html_data);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $date
     * @return bool|string
     */
    public function save_word(Request $request, $date)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $word_content = new FormatDocFileData();
        $get_info_date = new GetInfoDate();

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

        $content = $word_content->template_start() . $word_content->content_data($result) . $word_content->template_footer();

        $filename = v4() . ".doc";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о смене $date в формате Word", "save-all-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со смены $date в формате Word", "save-all-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $content);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $date
     * @return string
     */
    public function save_pdf(Request $request, $date)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $word_content = new FormatDocFileData();
        $get_info_date = new GetInfoDate();

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

        $html_data = $templates_save->template_html($result);

        $pdf = new Dompdf();
        $pdf->loadHTML($html_data);
        $pdf->getOptions()->set('defaultFont', 'DejaVu Sans');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $data_pdf = $pdf->output();

        $filename = v4() . ".pdf";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о смене $date в формате PDF", "save-all-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со смены $date в формате PDF", "save-all-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $data_pdf);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }
}
