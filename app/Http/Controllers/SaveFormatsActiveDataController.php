<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\FormatDocFileData;
use App\Http\Middleware\GetInfoDate;
use App\Http\Middleware\Logging;
use App\Http\Middleware\QueryFilter;
use App\Http\Middleware\ReturnRequest;
use App\Http\Middleware\TemplatesSaves;
use App\Models\User;
use Barryvdh\DomPDF\Facade\PDF;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function Ramsey\Uuid\v4;

class SaveFormatsActiveDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function save_html(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $get_info_date = new GetInfoDate();
        $templates_save = new TemplatesSaves();

        $token = $request->header("user-token");
        
        date_default_timezone_set(env("TIMEZONE"));

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Охранник") !== true){
            return $check_role->role_check($request);
        }

        $user = User::where("token", $token)->get();

        $datas = $get_info_date->get_data();
        $active_date = date("d_m_Y");
        $active_date_format = date("d.m.Y");

        $result = [
            [
                "date" => $active_date_format,
                "data" => $datas
            ],
        ];

        $html_data = $templates_save->template_html($result);

        $filename = v4() . ".html";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация об сотрудниках прошедших на смену $active_date_format", "save-active-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к сотрудникам пришеедших на смену $active_date_format", "save-active-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $html_data);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function save_pdf(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $get_info_date = new GetInfoDate();
        $templates_save = new TemplatesSaves();

        $token = $request->header("user-token");

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Охранник") !== true){
            return $check_role->role_check($request);
        }

        $user = User::where("token", $token)->get();

        $datas = $get_info_date->get_data();
        $active_date = date("d_m_Y");
        $active_date_format = date("d.m.Y");

        $result = [
            [
                "date" => $active_date_format,
                "data" => $datas
            ],
        ];

        $html_data = $templates_save->template_html($result);

        $filename = v4() . ".pdf";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $pdf = new Dompdf();
        $pdf->loadHTML($html_data);
        $pdf->getOptions()->set('defaultFont', 'DejaVu Sans');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $data_pdf = $pdf->output();

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $data_pdf);

        $logging->add_log_ip("была получена информация об сотрудниках прошедших на смену $active_date_format", "save-active-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к сотрудникам пришеедших на смену $active_date_format", "save-active-data.log");

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function save_word(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $get_info_date = new GetInfoDate();
        $word_content = new FormatDocFileData();

        $token = $request->header("user-token");

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Охранник") !== true){
            return $check_role->role_check($request);
        }

        $user = User::where("token", $token)->get();

        $datas = $get_info_date->get_data();
        $active_date = date("d_m_Y");
        $active_date_format = date("d.m.Y");

        $result = [
            [
                "date" => $active_date_format,
                "data" => $datas
            ],
        ];

        $content = $word_content->template_start() . $word_content->content_data($result) . $word_content->template_footer();

        $filename = v4() . ".doc";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $content);

        $logging->add_log_ip("была получена информация об сотрудниках прошедших на смену $active_date_format", "save-active-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к сотрудникам пришеедших на смену $active_date_format", "save-active-data.log");

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return bool|string
     */
    public function save_excel(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $get_info_date = new GetInfoDate();
        $word_content = new FormatDocFileData();
        $templates_save = new TemplatesSaves();

        $token = $request->header("user-token");

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Охранник") !== true){
            return $check_role->role_check($request);
        }

        $user = User::where("token", $token)->get();

        $datas = $get_info_date->get_data();
        $active_date = date("d_m_Y");
        $active_date_format = date("d.m.Y");

        $result = [
            [
                "date" => $active_date_format,
                "data" => $datas
            ],
        ];

        $excel_data = $templates_save->template_excel($result);

        $filename = v4() . ".xls";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $excel_data);

        $logging->add_log_ip("была получена информация об сотрудниках прошедших на смену $active_date_format", "save-active-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к сотрудникам пришеедших на смену $active_date_format", "save-active-data.log");

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

}
