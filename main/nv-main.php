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
        $_ENV['nv-api-name'] = '';


        $_ENV['nv-root']['user'] = 'root';
        $_ENV['nv-root']['password'] = '2058969';

        $_ENV['nv-settings'] = $settings;
        
        $_ENV['nv-file-identifiquer'] = '';

        $_ENV['nv-path-https'] = 'https/';
        $_ENV['nv-path-errors'] = $settings['paths']['errors'];
        
        $_ENV['nv-database-default'] = 'default';

        $_ENV['nv-databases']['dafault']    = 'default';
        $_ENV['nv-databases']['list']       = $settings['databases'];

        $_ENV['nv-path-conf'] = $settings['path-config'];
    }

    private function listItems(array $items):string
    {
        $list = array_reduce($items, function(string $carry, string $item){
            $carry .= ", $item";
            return $carry;
        });

        return ltrim($list, ', ');
    }

    public function setApiName(string $name)
    {
        $_ENV['nv-api-name'] = $name;
    }

    /**
     * Estable las cabecerea permitidas al cliente
     * @param string|array $headers 
     */
    public function setHeaders(string|array $headers):void
    {
        if (is_array($headers)) $headers = $this->listItems($headers);
        $this->headers = $headers;
    }

    /**
     * Establce los oriqines que tiene acceso a las peticiones HTTP
     */
    public function setOrigin(string|array $origin):void
    {
        if (is_array($origin)) $origin = $this->listItems($origin);
        $this->origin = $origin;
    }

    /**
     * Establce los método que soporta las peticiones HTTP
     */
    public function setMothods(string|array $methods):void
    {
        if (is_array($methods)) $this->listItems($methods);
        $this->methods = $methods;
    }

    public function setDatabaseDefault(string $datbase_name):void
    {
        $_ENV['nv-database-default'] = $datbase_name;
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

    /**
     * Ejecuta la petición HTTP.
     */
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