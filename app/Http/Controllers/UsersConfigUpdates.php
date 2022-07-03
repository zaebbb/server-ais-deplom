<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\GetUsersAdmin;
use App\Http\Middleware\Logging;
use App\Http\Middleware\QueryFilter;
use App\Http\Middleware\ReturnRequest;
use App\Models\Enclosures;
use App\Models\Posts;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;

class UsersConfigUpdates extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function all_users(Request $request)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $query_filter = new QueryFilter();
        $get_user = new GetUsersAdmin();

        $token = $request->header("user-token");
        $user_token = User::where("token", $token)->get();
        $login = $user_token[0]->login;

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $all_users_result = [];

        $all_users = User::all();

        foreach($all_users as $user){
            $all_users_result[] = $get_user->get_user($user);
        }

        $logging->add_log_ip("были получены данные пользователей", "user-config.log");
        $logging->add_log_user("Пользователь $login получил данные всех пользователей", "user-config.log");

        return $return_request->return_request($all_users_result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function get_user(Request $request, $id)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $query_filter = new QueryFilter();
        $get_user = new GetUsersAdmin();

        $token = $request->header("user-token");
        $user_data = User::where("token", $token)->get();
        $login_admin = $user_data[0]->login;

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $user = User::find($id);

        if($user === null){ return $return_request->return_request(["Пользователь не найден"], 404); }

        $user_info = $get_user->get_user($user);
        $login = $user->login;

        $logging->add_log_ip("были получены данные пользователя $login", "user-config.log");
        $logging->add_log_user("Пользователь $login_admin получил данные пользователя $login", "user-config.log");

        return $return_request->return_request($user_info, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function delete_hash_users(Request $request)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();
        $query_filter = new QueryFilter();

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $login = $user[0]->login;

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $directory_users = scandir(public_path("tmp/"));
        array_shift($directory_users);
        array_shift($directory_users);

        foreach($directory_users as $directory){
            $files = scandir(public_path("tmp/$directory"));
            array_shift($files);
            array_shift($files);

            foreach($files as $file){
                unlink(public_path("tmp/$directory/$file"));
            }
        }

        $logging->add_log_ip("были удалены хэш-файлы пользователей", "user-config.log");
        $logging->add_log_user("Пользователь $login удалил хэш-файлы", "user-config.log");

        return $return_request->return_request(["Все файлы были удалены"], 200);
    }
}
