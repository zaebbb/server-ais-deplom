<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthCheck
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function auth_check($request)
    {
        $token = $request->header("user-token");
        $search_token = User::where("token", $token)->get();

        if(count($search_token) === 0){
            return response()
                ->json([
                    "code" => 403
                ])
                ->header("Content-Type", "application/json")
                ->setStatusCode(403);
        }

        return true;
    }
}
