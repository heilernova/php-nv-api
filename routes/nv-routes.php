<?php
namespace nv\api;

require_once 'nv-routes-find.php';
require_once 'nv-route.php';

class Routes
{
    private static array $routes = [];

    public static function add(string $url, $controller, $cuthom_method = null)
    {
        self::$routes[] = new Route($url, $controller, $cuthom_method);
    }

    public static function getRoutes():array
    {
        return self::$routes;
    }
}