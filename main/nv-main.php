<?php

namespace nv\api;
/**
 * @author Heiler Nova
 */
class Main
{
    private array $routes = [];
    private string $headers = '';
    private string $methods = '';
    private string $origin = '';

    public function __construct(array $settings, array $routes = null)
    {
        $_ENV['nv-settings'] = $settings;
        $_ENV['nv-file-identifiquer'] = '';
        $_ENV['nv-path-https'] = 'https/';
        $_ENV['nv-path-errors'] = 'errors/';
    }

    private function listItems(array $items):string
    {
        $list = array_reduce($items, function(string $carry, string $item){
            $carry .= ", $item";
            return $carry;
        });

        return ltrim($list, ', ');
    }

    public function setHeaders(string|array $headers):void
    {
        if (is_array($headers)) $headers = $this->listItems($headers);
        $this->headers = $headers;
    }

    public function setOrigin(string|array $origin):void
    {
        if (is_array($origin)) $origin = $this->listItems($origin);
        $this->origin = $origin;
    }

    public function setMothods(string|array $methods):void
    {
        if (is_array($methods)) $this->listItems($methods);
        $this->methods = $methods;
    }

    public function setFileIdentifiquer(string $text_identifiquer):void
    {
        $_ENV['nv-file-identifiquer'] = $text_identifiquer;
    }

    public function routesAdd($url, $namespace_controller, $cuthom_method):void
    {
        $this->routes[] = new Route($url, $namespace_controller, $cuthom_method);
    }

    public function setRoutes(array $routes):void
    {
        $this->routes = $routes;
    }

    public function run(string $http_url):void
    {
        header('content-type: application/json');

        date_default_timezone_set('UTC');

        $this->routes[] = new Route('nv/errors/view', function(){  ErrorController::rederIndex(); });
        $this->routes[] = new Route('nv/errors/clear', function(){  ErrorController::clear(); });

        $url = trim($http_url, '/');

        if (empty($url)){

            response("Empty http request");

        }else{

            $routes = nv_routes_find($url, $this->routes);

            if ($routes){

                $routes->execute();

            }else{

                response('Not found', 404);
            }

        }
    }
    
}