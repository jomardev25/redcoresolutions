<?php

if (!function_exists('set_active')) {
    function set_active($path, $active = 'active')
    {
        return call_user_func_array('Request::is', (array) $path) ? $active : '';
    }
}


if (!function_exists('get_breadcrumbs')) {
    function get_breadcrumbs()
    {
        return collect(request()->segments())->mapWithKeys(function ($segment, $key) {
            return [
                $segment => implode('/', array_slice(request()->segments(), 0, $key + 1))
            ];
        });
    }
}
