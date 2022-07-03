<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AllDatas;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\FormatDocFileData;
use App\Http\Middleware\Logging;
use App\Http\Middleware\QueryFilter;
use App\Http\Middleware\ReturnRequest;
use App\Http\Middleware\TemplatesSaves;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Ramsey\Uuid\v4;

class SaveMonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param $month
     * @return bool|string
     */
    public function save_month_html(Request $request, $month = "")
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $query_filter = new QueryFilter();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $token = $user[0]->login;

        $month_datas = $all_datas->edit_month($month);

        $array_datas = $all_datas->all_datas($month_datas);

        $html_data = $templates_save->template_html($array_datas);

        $filename = v4() . ".html";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о всех датах в месяце $month в HTML формате!", "save-month-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со смен в месяце $month в HTML формате!", "save-month-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $html_data);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $month
     * @return bool|string
     */
    public function save_month_excel(Request $request, $month)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $query_filter = new QueryFilter();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $token = $user[0]->login;

        $month_datas = $all_datas->edit_month($month);

        $array_datas = $all_datas->all_datas($month_datas);

        $html_data = $templates_save->template_excel($array_datas);

        $filename = v4() . ".xls";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о всех датах в месяце $month в Excel формате!", "save-month-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со всех смен в месяце $month в Excel формате!", "save-month-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $html_data);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $month
     * @return bool|string
     */
    public function save_month_word(Request $request, $month)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $query_filter = new QueryFilter();
        $word_content = new FormatDocFileData();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $token = $user[0]->login;

        $month_datas = $all_datas->edit_month($month);

        $array_datas = $all_datas->all_datas($month_datas);

        $content = $word_content->template_start() . $word_content->content_data($array_datas) . $word_content->template_footer();

        $filename = v4() . ".doc";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о всех датах в месяце $month в Word формате!", "save-month-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со всех смен в месяце $month в Word формате!", "save-month-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $content);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param $month
     * @return string
     */
    public function save_month_pdf(Request $request, $month)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $templates_save = new TemplatesSaves();
        $all_datas = new AllDatas();
        $query_filter = new QueryFilter();
        $word_content = new FormatDocFileData();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $token = $user[0]->login;

        $month_datas = $all_datas->edit_month($month);

        $array_datas = $all_datas->all_datas($month_datas);

        $html_data = $templates_save->template_html($array_datas);

        $pdf = new Dompdf();
        $pdf->loadHTML($html_data);
        $pdf->getOptions()->set('defaultFont', 'DejaVu Sans');
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        $data_pdf = $pdf->output();

        $filename = v4() . ".pdf";
        $hash_dir = $user[0]->qr_image;
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о всех датах в месяце $month в Word формате!", "save-month-data.log");
        $logging->add_log_user("Пользователь $login получил доступ к информации со всех смен в месяце $month в Word формате!", "save-month-data.log");

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $data_pdf);

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }
}
