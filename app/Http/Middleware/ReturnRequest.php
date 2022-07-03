<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class ReturnRequest
{

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function return_request($data = [], $code = 200)
    {
        return response()
            ->json([
                "code" => $code,
                "data_response" => $data
            ])
            ->header("Content-Type", "application/json")
            ->setStatusCode($code);
    }
}
