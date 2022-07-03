<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\GetInfoDate;
use App\Http\Middleware\Logging;
use App\Http\Middleware\QueryFilter;
use App\Http\Middleware\ReturnRequest;
use App\Models\Enclosures;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserInfo;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ViewDateActiveDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function view_date(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $get_info_date = new GetInfoDate();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Охранник") !== true){
            return $check_role->role_check($request);
        }

        $logging->add_log_ip("были получены данные об авторизованных пользователях за активную смену", "save-active-data.log");

        return $return_request->return_request($get_info_date->get_data(), 201);
    }
}
