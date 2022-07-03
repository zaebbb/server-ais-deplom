<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class QueryFilter
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param $query_array
     * @return array
     */
    public function query_filter($query_array, $element_name)
    {
        $array = [];

        foreach($query_array as $element){
            $array[] = $element->$element_name;
        }

        return $array;
    }
}
