<?php

namespace App\Http\Middleware;

use App\Models\Roles;
use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AccessCheck
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $access
     * @return string|null
     */
    public function role_check($request, $access = "Охранник")
    {
        $token = $request->header("user-token");
        $search_token = User::where("token", $token)->get();
        $query_filter = new QueryFilter();

        $search_role = Roles::
            leftJoin("user_roles", "roles.id", "=", "user_roles.role_id")
            ->where("user_roles.user_id", $search_token[0]->id)
            ->get();

        $filter_roles = in_array($access, $query_filter->query_filter($search_role, "role"), true);

        if($filter_roles !== true){
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
