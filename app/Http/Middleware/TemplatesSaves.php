<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class TemplatesSaves
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param array $datas
     * @return string|null
     */
    public function template_html($datas = [])
    {
        $styles = "<!DOCTYPE html>
        <html lang=\"ru\"><head>
        <meta charset=\"UTF-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Данные</title>
        </head><body>
        <style>
        *{
            font-family: \"DejaVu Sans\";
            font-size: 14px;
        }

        table{
            margin-bottom: 50px;
        }

        td,
        th,
        tr,
        table{
            border-collapse: collapse;
            border: 1px solid #000;
        }

        td,
        th{
            padding: 5px 10px;
        }

        h1{
            font-size: 28px;
        }
    </style>";

        $footer = "</body></html>";

        $content = "";

        foreach($datas as $array_data){
            $content .= "<h1>" . $array_data["date"] ."</h1>
               <table><tr><th>Логин</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Роли в сервисе</th><th>Работает на корпусах</th><th>Должности</th><th>Взаимодействие</th><th>Рабочее время</th></tr>";

            foreach($array_data["data"] as $data_one){
                $content .= "<tr>";
                foreach($data_one as $key => $data){
//                    var_dump($data);
                    if(is_object($data)){
//                        var_dump($data->toArray());
                         $content .= "<td>" . implode("<br>", $data->toArray()) . "</td>";
                    } else if(is_array($data)){
//                        var_dump($data);
                        $content .= "<td>" . implode("<br>", $data) . "</td>";
                    } else {
                        $content .= "<td>" . $data . "</td>";
                    }
                }
                $content .= "</tr>";
            }
            $content .= "</table>";
        }

        return $styles . $content . $footer;
    }

    public function template_excel($datas = []){
        $styles = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
   <html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
	<head>
		<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" />
		<meta name=\"author\" content=\"zabey\" />
		<title>Demo</title>
	</head>
	<body>
        <style>
        *{
            font-family: \"DejaVu Sans\";
            font-size: 14px;
        }

        table{
            margin-bottom: 50px;
        }

        td,
        th,
        tr,
        table{
            border-collapse: collapse;
            border: 1px solid #000;
        }

        td,
        th{
            padding: 5px 10px;
        }

        h1{
            font-size: 28px;
        }
    </style>";

        $footer = "</body></html>";

        $content = "";

        foreach($datas as $array_data){
            $content .= "<h1>" . $array_data["date"] ."</h1>
               <table><tr><th>Логин</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Роли в сервисе</th><th>Работает на корпусах</th><th>Должности</th><th>Взаимодействие</th><th>Рабочее время</th></tr>";

            foreach($array_data["data"] as $data_one){
                $content .= "<tr>";
                foreach($data_one as $key => $data){
//                    var_dump($data);
                    if(is_object($data)){
//                        var_dump($data->toArray());
                        $content .= "<td>" . implode("<br>", $data->toArray()) . "</td>";
                    } else if(is_array($data)){
//                        var_dump($data);
                        $content .= "<td>" . implode("<br>", $data) . "</td>";
                    } else {
                        $content .= "<td>" . $data . "</td>";
                    }
                }
                $content .= "</tr>";
            }
            $content .= "</table>";
        }

        return $styles . $content . $footer;
    }
}
