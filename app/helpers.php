<?php

if (!function_exists('base_path')) {
    function base_path($path = '') {
        return __DIR__ . '/..//' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('env')) {
    function env($key, $default = null) {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        switch (strtolower($value)) {
            case $value === 'true';
                return true;
            case $value === 'false';
                return false;
            default:
                return $value;
        }
    }
}

if (!function_exists('debug')) {
    function debug()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

if (!function_exists('debug')) {
    function match_wildcard($wildcard_pattern, $haystack)
    {
        $regex = str_replace(
            array("\*", "\?"), // wildcard chars
            array('.*','.'),   // regexp chars
            preg_quote($wildcard_pattern)
        );

        return preg_match('/^' . $regex . '$/is', $haystack);
    }
}
