<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Logging
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param $message
     * @param string $filename
     * @return string|null
     */
    public function add_log_user($message, $filename = "file.log")
    {
        date_default_timezone_set(env("TIMEZONE"));
        $datetime = date("Y-m-d H:i:s");
        file_put_contents(public_path("logs/" . $filename), ">> [$datetime] | $message" . PHP_EOL, FILE_APPEND);
    }

    public function add_log_ip($message, $filename = "file.log")
    {
        // script ip user
        $client = @$_SERVER["HTTP_CLIENT_IP"];
        $forward = @$_SERVER["HTTP_X_FORWARDED_FOR"];
        $remote = @$_SERVER["REMOTE_ADDR"];

        if(filter_var($client, FILTER_VALIDATE_IP)) { $ip = $client; }
        else if(filter_var($forward, FILTER_VALIDATE_IP)) { $ip = $forward; }
        else { $ip = $remote; }

        date_default_timezone_set(env("TIMEZONE"));
        $datetime = date("Y-m-d H:i:s");
        file_put_contents(public_path("logs/" . $filename), ">> [$datetime] | С IP адреса \"$ip\" $message" . PHP_EOL, FILE_APPEND);
    }
}
