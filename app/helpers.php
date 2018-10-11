<?php

if ( ! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     *
     * @param  string $routes
     * @param  bool $condition
     * @return string
     */
    function active($routes, bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array)$routes) && $condition ? 'active' : '';
    }
}

if ( ! function_exists('number')) {
    /**
     * Return the calculated entity number.
     *
     * @param  mixed $result
     * @param  mixed $loop
     * @return int
     */
    function number($result, $loop)
    {
        return (($result->total() - $loop->iteration) + 1) - (($result->currentPage() - 1) * $result->perPage());
    }
}

if ( ! function_exists('random_color_part')) {
    /**
     * Generate random color part for make hex color code.
     *
     * @return string
     */
    function random_color_part()
    {
        return str_pad(dechex(mt_rand( 0, 255)), 2, '0', STR_PAD_LEFT);
    }
}


if ( ! function_exists('random_color')) {
    /**
     * Generate random color for make hex color full code.
     *
     * @return string
     */
    function random_color()
    {
        return random_color_part() . random_color_part() . random_color_part();
    }
}

if (! function_exists('active')) {
    /**
     * Sets the menu item class for an active route.
     *
     * @param  string  $routes
     * @param  bool  $condition
     * @return string
     */
    function active($routes, bool $condition = true): string
    {
        return call_user_func_array([app('router'), 'is'], (array) $routes) && $condition ? 'active' : '';
    }
}