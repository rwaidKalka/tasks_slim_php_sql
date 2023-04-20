<?php
if (!function_exists('base_path'))
{
    function base_path($path = '')
    {
        return  __DIR__ . "/../{$path}";
    }
}

if (!function_exists('app_path'))
{
    function app_path($path = '')
    {
        return  __DIR__ . "/../app/{$path}";
    }
}


if (!function_exists('database_path'))
{
    function database_path($path = 'database.php')
    {
        return app_path("config/{$path}");
    }
}


if (!function_exists('public_path'))
{
    function public_path($path = '')
    {
        return base_path("public/{$path}");
    }
}

if (!function_exists('uploads_path'))
{
    function uploads_path($path = '')
    {
        return public_path("uploads/{$path}");
    }
}

if (!function_exists('routes_path'))
{
    function routes_path($path = '')
    {
        return app_path("routes/{$path}");
    }
}

if (!function_exists('controllers_path'))
{
    function controllers_path($path = '')
    {

        return app_path("controllers/{$path}");
    }
}

if (!function_exists('models_path'))
{
    function models_path($path = '')
    {
        return app_path("models/{$path}");
    }
}

if (!function_exists('middleware_path'))
{
    function middleware_path($path = '')
    {
        return app_path("middleware/{$path}");
    }
}

if (!function_exists('config_path'))
{
    function config_path($path = '')
    {
        return app_path("config/{$path}");
    }
}