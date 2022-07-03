<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AccessCheck;
use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\Logging;
use App\Http\Middleware\QueryFilter;
use App\Http\Middleware\ReturnRequest;
use App\Models\Enclosures;
use App\Models\Posts;
use App\Models\Roles;
use Illuminate\Http\Request;

class EditStaticDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function get_roles(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $roles = Roles::all();
        $filter_roles = $query_filter->query_filter($roles, "role");

        $logging->add_log_ip("была получена информация о ролях пользователей в системе", "action-data.log");

        return $return_request->return_request($filter_roles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function get_posts(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $posts = Posts::all();
        $filter_posts = $query_filter->query_filter($posts, "post");

        $logging->add_log_ip("была получена информация о должностях предприятия", "action-data.log");

        return $return_request->return_request($filter_posts, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function get_corpuses(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $enclosures = Enclosures::all();
        $filter_enclosures = $query_filter->query_filter($enclosures, "corpus");

        $logging->add_log_ip("была получена информация о корпусах предприятия", "action-data.log");

        return $return_request->return_request($filter_enclosures, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return bool|string
     */
    public function add_post(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $post = $request->post;

        if(empty($post)){ return $return_request->return_request(
            ["post_required" => 'Поле "post" обязательно к заполнению'], 400
        ); }

        $search_post = Posts::where("post", $post)->get();

        if(count($search_post) !== 0){ return $return_request->return_request(
            ["post_unique" => "Специальность уже существует"], 400
        ); }

        $logging->add_log_ip("была добавлена новая специальность $post в БД системы", "action-data.log");

        $create = Posts::create([
            "post" => $post
        ]);

        return $return_request->return_request("Добавлена новая специальность: $post");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return string
     */
    public function add_corpus(Request $request)
    {
        $return_request = new ReturnRequest();
        $query_filter = new QueryFilter();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $corpus = $request->corpus;

        if(empty($corpus)){ return $return_request->return_request(
            ["corpus_required" => 'Поле "corpus" обязательно к заполнению'], 400
        ); }

        $search_post = Enclosures::where("corpus", $corpus)->get();

        if(count($search_post) !== 0){ return $return_request->return_request(
            ["corpus_unique" => "Корпус уже существует"], 400
        ); }

        $logging->add_log_ip("был добавлен новый корпус $corpus в БД системы", "action-data.log");

        $create = Enclosures::create([
            "corpus" => $corpus
        ]);

        return $return_request->return_request("Добавлен новый корпус: $corpus");
    }
}
