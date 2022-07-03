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
use App\Models\Enclosures;
use App\Models\Posts;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserCorpus;
use App\Models\UserInfo;
use App\Models\UserPost;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use function Ramsey\Uuid\v4;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return bool|string
     */
    public function create_user(Request $request)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        $token = $request->header("user-token");

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        // starting info
        $login = $request->login;
        $password = $request->password;
        // токен QR кода
        $qr_token = $request->qr_token;
        // хэш изображение которое сгенерирует как изображение
        $hash_image_qr = $request->hash_image_qr;
        // токен авторизации
        $token = Str::random(60);
        // токен доступа к внутренним файлам сервиса
        $access_token = Str::random(60);

        $search_user = User::where("login", $login)->get();

        // user info
        $name = $request->name;
        $surname = $request->surname;
        $patronymic = $request->patronymic;
        $birthday = $request->birthday;
        $gender = $request->gender;
        $avatar = $request->hasFile("avatar");

        // roles
        $roles = $request->roles;

        // posts
        $posts = $request->posts;

        // enclosures
        $enclosures = $request->enclosures;

        $errors = [];

        if(empty($login)){ $errors["login_required"] = "Поле логина обязательно для заполнения"; }
        if(count($search_user) !== 0){ $errors["login_unique"] = "Введеный вами логин уже существует"; }
        if(empty($password)){ $errors["password_required"] = "Поле пароля обязательно для заполнения"; }
        if(empty($qr_token)){ $errors["qr_token_error"] = "Ошибка при генерации QR токена"; }
        if(empty($hash_image_qr)){ $errors["qr_code_error"] = "Ошибка при генерации QR кода"; }

        if(empty($name)){ $errors["name_required"] = "Поле имени обязательно к заполнению"; }
        if(empty($surname)){ $errors["surname_required"] = "Поле фамилии обязательно к заполнению"; }
        if(empty($patronymic)){ $errors["patronymic_required"] = "Поле отчества обязательно к заполнению"; }
        if(empty($birthday)){ $errors["birthday_required"] = "Поле даты рождения обязательно к заполнению"; }
        if(empty($gender)){ $errors["gender_required"] = "Поле пола обязательно к заполнению"; }

        if(empty($roles)){ $errors["roles_required"] = "Пользователь должен иметь как минимум 1 роль"; }
        if(empty($posts)){ $errors["posts_required"] = "Пользователь должен иметь как минимум 1 должность"; }
        if(empty($enclosures)){ $errors["enclosures_required"] = "Пользователь должен иметь как минимум 1 корпус"; }

        if($avatar){
            if(
                !strpos($request->file("avatar")->getClientOriginalName(), ".png") &&
                !strpos($request->file("avatar")->getClientOriginalName(), ".jpg") &&
                !strpos($request->file("avatar")->getClientOriginalName(), ".svg")
            ){
                $errors["file_format_error"] = "Недопустимый формат загружаемого файла";
            }

            if($request->file("avatar")->getSize() > 1024 * 1024){
                $errors["file_size_error"] = "Недопустимый размер загружаемого файла";
            }
        }

        if(count($errors) !== 0){
            return $return_request->return_request($errors, 400);
        }

        $create_user = User::create([
            "login" => $login,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "token" => $token,
            "qr_token" => $qr_token,
            "qr_image" => $access_token
        ]);

        $filename = "";
        if($avatar){
            if(strpos($request->file("avatar")->getClientOriginalName(), ".svg")){
                $filename = v4() . ".svg";
            } else { $filename = v4() . ".png"; }

            $request->file("avatar")->move(public_path("avatars/"), $filename);
        }

        $create_user_data = UserInfo::create([
            "id" => $create_user->id,
            "name" => $name,
            "surname" => $surname,
            "patronymic" => $patronymic,
            "birthday" => $birthday,
            "gender" => $gender,
            "avatar" => $filename,
        ]);

        $roles = mb_str_split($roles);
        $roles_storage = [];
        $enclosures = mb_str_split($enclosures);
        $enclosures_storage = [];
        $posts = mb_str_split($posts);
        $posts_storage = [];

        foreach($roles as $role){
            UserRole::create([
                "user_id" => $create_user->id,
                "role_id" => $role
            ]);
            $role_one = Roles::find($role);
            $roles_storage[] = $role_one->role;
        }

        foreach($enclosures as $corpus){
            UserCorpus::create([
                "user_id" => $create_user->id,
                "corpus_id" => $corpus
            ]);
            $corpus_one = Enclosures::find($corpus);
            $enclosures_storage[] = $corpus_one->corpus;
        }

        foreach($posts as $post){
            UserPost::create([
                "user_id" => $create_user->id,
                "post_id" => $post
            ]);
            $post_one = Posts::find($post);
            $posts_storage[] = $post_one->corpus;
        }

        $create_hash_dir = mkdir(public_path("tmp/$access_token"));
        $generate_image = file_put_contents(public_path("qrcodes_hash/$access_token"), $hash_image_qr);

        $logging->add_log_ip("был создан новый пользователь: $login", "users-logs.log");
        $logging->add_log_user("Был создан новый пользователь: $login", "users-logs.log");

        return $return_request->return_request([
            "id" => $create_user->id,
            "login" => $login,
            "password" => $password,
            "name" => $name,
            "surname" => $surname,
            "patronymic" => $patronymic,
            "birthday" => $birthday,
            "avatar" => $filename,
            "roles" => $roles_storage,
            "enclosures" => $enclosures_storage,
            "posts" => $posts_storage,
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return bool|string
     */
    public function save_logs(Request $request)
    {
        $return_request = new ReturnRequest();
        $check_auth = new AuthCheck();
        $check_role = new AccessCheck();
        $logging = new Logging();

        $token = $request->header("user-token");

        if($check_auth->auth_check($request) !== true){
            return $check_auth->auth_check($request);
        }

        if($check_role->role_check($request, "Администратор") !== true){
            return $check_role->role_check($request);
        }

        $user = User::where("token", $token)->get();
        $login = $user[0]->login;

        $logging->add_log_ip("была получена информация о логах программы", "users-logs.log");
        $logging->add_log_user("Пользователь $login получил информацию о логах", "users-logs.log");

        $dir_files = scandir(public_path("logs/"));
        array_shift($dir_files);
        array_shift($dir_files);

        return $return_request->return_request([
            "files" => $dir_files
        ], 200);
    }
}
