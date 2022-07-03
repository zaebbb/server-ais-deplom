<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DateController;
use App\Http\Controllers\EditStaticDataController;
use App\Http\Controllers\SaveAllController;
use App\Http\Controllers\SaveDateController;
use App\Http\Controllers\SaveFormatsActiveDataController;
use App\Http\Controllers\SaveMonthController;
use App\Http\Controllers\SaveYearController;
use App\Http\Controllers\UserDataUpdateController;
use App\Http\Controllers\UsersConfigUpdates;
use App\Http\Controllers\ViewAllDataController;
use App\Http\Controllers\ViewDateActiveDataController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth
Route::post("/login", [AuthController::class, "login"]); 
Route::get("/logout", [AuthController::class, "logout"]); 
Route::get("/check-auth", [AuthController::class, "check_auth"]); 

// user
Route::get("/user-data", [UserDataUpdateController::class, "user_data"]); 
Route::post("/update-data", [UserDataUpdateController::class, "update_data"]);
Route::post("/update-qr-hash", [UserDataUpdateController::class, "update_qr_hash"]); 
Route::post("/save-data", [UserDataUpdateController::class, "save_data"]); 
Route::post("/delete-hash", [UserDataUpdateController::class, "delete_hash"]); 

// security
Route::get("/check-date", [DateController::class, "check_date"]); 
Route::post("/employee-verify/{hash}", [DateController::class, "user_verify"]); 

// просмотреть персонал конкретной смены
Route::get("/view-date", [ViewDateActiveDataController::class, "view_date"]); 

Route::post("/view-date/save-to-html", [SaveFormatsActiveDataController::class, "save_html"]); 
Route::post("/view-date/save-to-pdf", [SaveFormatsActiveDataController::class, "save_pdf"]); 
Route::post("/view-date/save-to-word", [SaveFormatsActiveDataController::class, "save_word"]); 
Route::post("/view-date/save-to-excel", [SaveFormatsActiveDataController::class, "save_excel"]); 

// admin
// создание также папки в папке tmp а так qr кода иго зависимостей в папках и тд
Route::post("/create-user", [AdminUserController::class, "create_user"]);
Route::get("/save-log", [AdminUserController::class, "save_logs"]); 

Route::get("/all-users", [UsersConfigUpdates::class, "all_users"]); 
Route::get("/all-users/{id}", [UsersConfigUpdates::class, "get_user"]); 
Route::post("/delete-hash-users", [UsersConfigUpdates::class, "delete_hash_users"]); 
Route::post("/all-users/{id}/delete", function(){ return response(); });
Route::post("/all-users/{id}/update", function(){ return response(); });

// добавить сохранение пользователей также в формате word

// get data and get dates
Route::get("/view-dates", [ViewAllDataController::class, "view_data"]);
Route::get("/view-dates/{date}", [ViewAllDataController::class, "view_date_value"]);

// save data in specially datetime
Route::post("/view-dates/{date}/save-to-html", [SaveDateController::class, "save_html"]); 
Route::post("/view-dates/{date}/save-to-excel", [SaveDateController::class, "save_excel"]); 
Route::post("/view-dates/{date}/save-to-word", [SaveDateController::class, "save_word"]); 
Route::post("/view-dates/{date}/save-to-pdf", [SaveDateController::class, "save_pdf"]); 

// save data in month or all data
Route::post("/view-dates/month/{month}/save-to-html", [SaveMonthController::class, "save_month_html"]); 
Route::post("/view-dates/month/{month}/save-to-excel", [SaveMonthController::class, "save_month_excel"]); 
Route::post("/view-dates/month/{month}/save-to-word", [SaveMonthController::class, "save_month_word"]); 
Route::post("/view-dates/month/{month}/save-to-pdf", [SaveMonthController::class, "save_month_pdf"]); 

// save data in year or all data
Route::post("/view-dates/year/{year}/save-to-html", [SaveYearController::class, "save_year_html"]); 
Route::post("/view-dates/year/{year}/save-to-excel", [SaveYearController::class, "save_year_excel"]); 
Route::post("/view-dates/year/{year}/save-to-word", [SaveYearController::class, "save_year_word"]); 
Route::post("/view-dates/year/{year}/save-to-pdf", [SaveYearController::class, "save_year_pdf"]); 

// сохранить все данные
Route::post("/view-dates/save-all-to-html", [SaveAllController::class, "save_all_to_html"]); 
Route::post("/view-dates/save-all-to-excel", [SaveAllController::class, "save_all_to_excel"]); 
Route::post("/view-dates/save-all-to-word", [SaveAllController::class, "save_all_to_word"]); 
Route::post("/view-dates/save-all-to-pdf", [SaveAllController::class, "save_all_to_pdf"]); 

// получение данных
Route::get("/get-roles", [EditStaticDataController::class, "get_roles"]); 
Route::get("/get-posts", [EditStaticDataController::class, "get_posts"]); 
Route::get("/get-corpus", [EditStaticDataController::class, "get_corpuses"]); 

Route::post("/add-post", [EditStaticDataController::class, "add_post"]); 
Route::post("/add-corpus", [EditStaticDataController::class, "add_corpus"]); 
