<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthCheck;
use App\Http\Middleware\ConvertToDoc;
use App\Http\Middleware\DocContentFormatUserInfo;
use App\Http\Middleware\Logging;
use App\Http\Middleware\QueryFilter;
use App\Http\Middleware\ReturnRequest;
use App\Models\Enclosures;
use App\Models\Posts;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Ramsey\Uuid\v4;

class UserDataUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function update_data(Request $request)
    {
        // required parameters
        $return_request = new ReturnRequest();
        $logging = new Logging();
        $check_auth = new AuthCheck();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $user_data = UserInfo::find($user[0]->id);

        $old_login = $user[0]->login;

        // user confidential
        $login = $request->login;
        $password = $request->password;

        // user  info
        $name = $request->name;
        $surname = $request->surname;
        $patronymic = $request->patronymic;
        $birthday = $request->birthday;
        $gender = $request->gender;
        $avatar = $request->hasFile("avatar");

        $errors = [];

        $search_login = User::where("login", $login)->get();

        if(empty($login)){ $errors["login_required"] = "Поле логина обязательно к заполнению"; }
        if(empty($password)){ $errors["password_required"] = "Поле пароля обязательно к заполнению"; }
        if(empty($name)){ $errors["name_required"] = "Поле имя обязательно к заполнению"; }
        if(empty($surname)){ $errors["surname_required"] = "Поле фамилии обязательно к заполнению"; }
        if(empty($patronymic)){ $errors["patronymic_required"] = "Поле отчества обязательно к заполнению"; }
        if($old_login !== $login && count($search_login) !== 0){ $errors["login_unique"] = "Значение логина не уникально"; }

        if($avatar){
            if(
                !strpos($request->file("avatar")->getClientOriginalName(), ".jpg") &&
                !strpos($request->file("avatar")->getClientOriginalName(), ".png")
            ){ $errors["avatar_type_not_support"] = "Выбранный вами формат изображения не поддерживается (доступны PNG, JPG)"; }

            if($request->file("avatar")->getSize() > 2 * 1024  * 1024){
                $errors["avatar_size"] = "Доступны к загрузке изображения не превышающие 2МБ";
            }
        }

        if(count($errors) !== 0){
            return $return_request->return_request([
                "errors" => $errors
            ], 400);
        }

        $logging->add_log_ip("было совершено изменение данных аккаунта $login", "account.log");
        if($login === $old_login){
            $logging->add_log_user("Логин пользователя $login остался без изменений", "account.log");
        } else {
            $logging->add_log_user("Логин пользователя $old_login изменили на $login", "account.log");
        }

        $filename = null;
        if($avatar){
            if($user_data->avatar !== null){
                unlink(public_path("avatars/") . $user_data->avatar);
            }

            $filename = v4() . ".jpg";

            $request->file("avatar")->move(public_path("avatars/"), $filename);
        }

        $user_data->update([
            "name" => $name,
            "surname" => $surname,
            "patronymic" => $patronymic,
            "birthday" => $birthday,
            "gender" => $gender,
            "avatar" => $filename
        ]);

        if($old_login === $login){
            $user[0]->update([
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ]);
        } else {
            $user[0]->update([
                "login" => $login,
                "password" => password_hash($password, PASSWORD_DEFAULT)
            ]);
        }

        return $return_request->return_request([
            "message" => "Данные успешно обновлены"
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool|string
     */
    public function update_qr_hash(Request $request)
    {
        // required parameters
        $return_request = new ReturnRequest();
        $logging = new Logging();
        $check_auth = new AuthCheck();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();

        $hash_qr = $request->hash_qr;
        $image_hash_qr = $request->image_hash_qr;

        $errors = [];

        if(empty($hash_qr)){ $errors["hash_qr_required"] = "Хэш обязателен для регистрации"; }
        if(empty($image_hash_qr)){ $errors["hash_image_qr_required"] = "Хэш изображения обязателен для регистрации"; }

        if(count($errors) !== 0) {
            return $return_request->return_request([
                "errors" => $errors
            ], 400);
        }

        file_put_contents(public_path("qrcodes_hash/" . $user[0]->qr_image), $image_hash_qr);
        $user[0]->update([
            "qr_token" => $hash_qr
        ]);

        $login = $user[0]->login;

        $logging->add_log_ip("произведена смена QR токена у пользователя $login", "account.log");
        $logging->add_log_user("Пользователь $login сменил QR токен", "account.log");

        return $return_request->return_request([
            "qr_hash" => $hash_qr,
            "qr_image" => $image_hash_qr
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return string
     */
    public function save_data(Request $request)
    {
        // required parameters
        $return_request = new ReturnRequest();
        $logging = new Logging();
        $check_auth = new AuthCheck();
        $create_file = new DocContentFormatUserInfo();
        $query_filter = new QueryFilter();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        $token = $request->header("user-token");

        $user = User::where("token", $token)->get();
        $user_info = UserInfo::find($user[0]->id);

        $user_corpuses = Enclosures::
            leftJoin("user_corpuses", "enclosures.id", "=", "user_corpuses.corpus_id")
            ->where("user_corpuses.user_id", $user[0]->id)
            ->get();

        $user_roles = Roles::
        leftJoin("user_roles", "user_roles.role_id", "=", "roles.id")
            ->where("user_roles.user_id", $user[0]->id)
            ->get();

        $user_posts = Posts::
            leftJoin("user_posts", "user_posts.post_id", "=", "posts.id")
            ->where("user_posts.user_id", $user[0]->id)
            ->get();

        $user_corpuses_filter = implode(", ", $query_filter->query_filter($user_corpuses, "corpus"));
        $user_roles_filter = implode(", ", $query_filter->query_filter($user_roles, "role"));
        $user_posts_filter = implode(", ", $query_filter->query_filter($user_posts, "post"));

        $file_info = [
            "Логин" => $user[0]->login,
            "Пароль" => "Не предоставляется",
            "Имя" => $user_info->name,
            "Фамилия" => $user_info->surname,
            "Отчество" => $user_info->patronymic,
            "Дата рождения" => $user_info->birthday,
            "Пол" => $user_info->gender,
            "Уровни доступа" => $user_roles_filter,
            "Должности" => $user_posts_filter,
            "Работает на корпусах" => $user_corpuses_filter,
        ];

        $filename = v4() . ".doc";
        $hash_dir = $user[0]->qr_image;

        $file_content = $create_file->template_start() . $create_file->main_content($user[0]->login, $file_info) . $create_file->template_end();

        file_put_contents(public_path("tmp/$hash_dir/$filename"), $file_content);

        $logging->add_log_ip("были сохранены данные пользователя " . $user[0]->login, "account.log");
        $logging->add_log_user("Пользователь " . $user[0]->login . " сохранил свои данные в файл doc по адресу tmp/$hash_dir/$filename", "account.log");

        return $return_request->return_request([
            "link" => "tmp/$hash_dir/$filename"
        ], 201);
    }

    public function delete_hash(Request $request){
        $return_request = new ReturnRequest();
        $logging = new Logging();
        $check_auth = new AuthCheck();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();
        $hash_dir = $user[0]->qr_image;

        $files = scandir(public_path("tmp/$hash_dir"));
        array_shift($files);
        array_shift($files);

        foreach($files as $file){
            unlink(public_path("tmp/$hash_dir/") . $file);
        }

        $logging->add_log_ip("была произведена очистка хэша пользователя " . $user[0]->login, "account.log");
        $logging->add_log_user("Пользователь " . $user[0]->login . " очистил свою хэш директорию", "account.log");

        return $return_request->return_request("Данные очищены", 200);
    }

    public function user_data(Request $request){
        $return_request = new ReturnRequest();
        $logging = new Logging();
        $check_auth = new AuthCheck();
        $query_filter = new QueryFilter();

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        $token = $request->header("user-token");
        $user = User::where("token", $token)->get();

        $user_data = UserInfo::find($user[0]->id);

        $posts = Posts::
            leftJoin("user_posts", "user_posts.post_id", "=", "posts.id")
            ->where("user_posts.user_id", $user[0]->id)
            ->get();

        $enclosures = Enclosures::
            leftJoin("user_corpuses", "user_corpuses.corpus_id", "=", "enclosures.id")
            ->where("user_corpuses.user_id", $user[0]->id)
            ->get();

        $roles = Roles::
            leftJoin("user_roles", "user_roles.role_id", "=", "roles.id")
            ->where("user_roles.user_id", $user[0]->id)
            ->get();

        $posts = $query_filter->query_filter($posts, "post");
        $enclosures = $query_filter->query_filter($enclosures, "corpus");
        $roles = $query_filter->query_filter($roles, "role");

        $qr_hash = file_get_contents(public_path("qrcodes_hash/" . $user[0]->qr_image));

        $logging->add_log_ip("были получены данные пользователя " . $user[0]->login, "account.log");
        $logging->add_log_user("Пользователь " . $user[0]->login . " получил свои данные", "account.log");

        return $return_request->return_request([
            "login" => $user[0]->login,
            "name" => $user_data->name,
            "surname" => $user_data->surname,
            "patronymic" => $user_data->patronymic,
            "birthday" => $user_data->birthday,
            "gender" => $user_data->gender,
            "avatar" => $user_data->avatar,
            "posts" => $posts,
            "enclosures" => $enclosures,
            "roles" => $roles,
            "qr_hash" => $qr_hash
        ], 200);
    }
}
