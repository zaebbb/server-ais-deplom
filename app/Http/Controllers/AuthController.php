<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\Logging;
use App\Http\Middleware\ReturnRequest;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return string
     */
    public function login(Request $request)
    {
        // required parameters
        $return_request = new ReturnRequest();
        $logging = new Logging();

        $login = $request->login;
        $password = $request->password;

        $search_user = User::where("login", $login)->get();

        $logging->add_log_ip("была произведена попытка входа в аккаунт");

        if(count($search_user) === 0 || !password_verify($password, $search_user[0]->password)){
            $logging->add_log_ip("была произведена недачная попытка входа в аккаунт");

            return $return_request->return_request([
                "message" => "Неверный логин или пароль"
            ], 400);
        }

        $regenerate_token = Str::random(60);
        $search_user[0]->update([
            "token" => $regenerate_token
        ]);

        $logging->add_log_ip("был совершен вход в аккаунт " . $search_user[0]->login);
        $logging->add_log_user("Пользователь " . $search_user[0]->login . " вошел в аккаунт");

        $search_roles = Roles::
            leftJoin("user_roles", "roles.id", "=", "user_roles.role_id")
            ->where("user_roles.user_id", "=", $search_user[0]->id)
            ->get();
        $filter_role = [];

        foreach($search_roles as $role){ $filter_role[] = $role->role; }

        return $return_request->return_request([
            "token" => $regenerate_token,
            "roles" => $filter_role
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function logout(Request $request)
    {
        // required parameters
        $return_request = new ReturnRequest();
        $logging = new Logging();
        $check_auth = new AuthCheck();

        $token = $request->header("user-token");
        $search_token = User::where("token", $token)->get();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        $logging->add_log_ip("был совершен выход из аккаунта");
        $logging->add_log_user("Пользователь " . $search_token[0]->login . " вышел из аккаунта");

        return $return_request->return_request([
            "message" => "Вы вышли из аккаунта"
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return bool
     */
    public function check_auth(Request $request)
    {
        // required parameters
        $return_request = new ReturnRequest();

        $token = $request->header("user-token");

        $search_user_token = User::where("token", $token)->get();

        if(count($search_user_token) !== 0){
            return $return_request->return_request([
                "check_result" => true
            ], 200);
        }

        return $return_request->return_request([
            "check_result" => false
        ], 200);
    }
}
