<?php

namespace App\Http\Middleware;

use App\Models\Enclosures;
use App\Models\Posts;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class GetUsersAdmin
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $access
     * @return array
     */
    public function get_user($user)
    {
        $query_filter = new QueryFilter();

        $user_data = UserInfo::find($user->id);

        $posts = Posts::
        leftJoin("user_posts", "user_posts.post_id", "=", "posts.id")
            ->where("user_posts.user_id", $user->id)
            ->get();

        $enclosures = Enclosures::
        leftJoin("user_corpuses", "user_corpuses.corpus_id", "=", "enclosures.id")
            ->where("user_corpuses.user_id", $user->id)
            ->get();

        $roles = Roles::
        leftJoin("user_roles", "user_roles.role_id", "=", "roles.id")
            ->where("user_roles.user_id", $user->id)
            ->get();

        $posts = $query_filter->query_filter($posts, "post");
        $enclosures = $query_filter->query_filter($enclosures, "corpus");
        $roles = $query_filter->query_filter($roles, "role");

        $qr_hash = file_get_contents(public_path("qrcodes_hash/" . $user->qr_image));

        return [
            "id" => $user->id,
            "qr_image" => $qr_hash,
            "login" => $user->login,
            "name" => $user_data->name,
            "surname" => $user_data->surname,
            "patronymic" => $user_data->patronymic,
            "birthday" => $user_data->birthday,
            "gender" => $user_data->gender,
            "avatar" => $user_data->avatar,
            "posts" => $posts,
            "enclosures" => $enclosures,
            "roles" => $roles
        ];
    }
}
