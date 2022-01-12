<?php
namespace nv\api;

use ReflectionMethod;

class Route
{
    public string  $url ='';
    public int     $urlItemsNum = 0;
    public array   $urlItems = [];

    private string $httpCustomMethod = '';
    public string $httpRequest = '';

    private string $namespaceController = '';

    public array $indexControllers = [];
    public array $indexParams = [];

    private $callable = null;


    public function __construct(string $url, string|callable  $namespace_controller, string $custom_method = null)
    {

        $this->url = $url; //'test/{name:string}/';
        $this->urlItems = explode('/', $url);
        $this->urlItemsNum = count($this->urlItems);
        
        // var_dump($namespace_controller);
        if (is_string($namespace_controller)){
            $this->namespaceController = $namespace_controller;
        }else{
            // echo "f";

            $this->callable = $namespace_controller;

        }

        $this->httpCustomMethod  = $custom_method ? $custom_method : '';

        $i = 0;
        foreach ($this->urlItems as $item){
            if (str_starts_with($item, '{')){
                $item = trim($item, "{");
                $item = trim($item, "}");
                $item = explode(':', $item);

                $data = [
                    'name'=>$item[0],
                    'type'=>$item[1] ?? 'string'
                ];

                $this->indexParams[] = [$i, $data];

            }else{
                $this->indexControllers[] = $i;
            }
            $i++;
        }

    }

    public function setHttpRequest(string $http_request):void
    {
        $this->httpRequest = trim($http_request, '/');
    }

    private function getController():?HttpController
    {
        $array_namespace = explode('\\', $this->namespaceController);
        $controller_name = str_split(lcfirst(array_pop($array_namespace)));

        $controller_file_name = array_reduce($controller_name, function($carry, $item){
            $carry .= ctype_upper($item) ? '-' . strtolower($item) : $item;
            return $carry;
        });

        $controller_file_name = str_replace('-controller', '.controller', $controller_file_name);
        $controller_file_name = $_ENV['nv-file-identifiquer'] . $controller_file_name;
        $controller_dir = '';
        
        $path_file = $_ENV['nv-path-https'] . "$controller_file_name.php";

        if (!file_exists($path_file)) $path_file = $_ENV['nv-path-https'] . "$controller_dir/$controller_file_name.php";

        if (file_exists($path_file)){

            require_once $path_file;
            $namespace = $this->namespaceController;
            return new $namespace();

        }else{

            return null;

        }

    }

    public function getParams():array|null
    {
        $url = $this->httpRequest;
        $url_items = explode('/', $url);
        $url_items_num = count($url_items);

        $params = [];

        foreach($this->indexParams as $item){

            $index = $item[0];
            $name = $item[1]['name'];
            $type = $item[1]['type'];

            $params[$name] = match($type){
                'int'   =>(int)$url_items[$index],
                'float' =>(float)$url_items[$index],
                default => $url_items[$index]
            };

        }

        return $params;
    }

    public function execute()
    {

        if (!$this->callable){

            $controller = $this->getController();
            if ($controller){
    
                $method = strtolower($_SERVER['REQUEST_METHOD']) . ($this->httpCustomMethod ? ucfirst($this->httpCustomMethod) : '');
                $params = $this->getParams();
    
                if (method_exists($controller, $method)){
    
                    $ref = new ReflectionMethod($controller, $method);
        
                    $param_number = $ref->getNumberOfParameters();
                    $param_number_required = $ref->getNumberOfRequiredParameters();
                    $num_params = $params ? count($params) : 0;
        
                    if ($param_number == $num_params || $param_number_required == $num_params){
        
                        if ($param_number == 0){
                            $controller->$method();
                        }else{
                            if ($num_params > 0){
                                try {
                                    $ref->invokeArgs($controller, $params);
                                } catch (\Throwable $th) {
                                    //throw $th;
                                    response('Error param URL', 400);
                                }
                            }else{
                                $controller->$method();
                            }
                        }
                    }
                }else{
                    response('Method not allowed for URL', 405);
                }
            }
        }else{
            $c = $this->callable;
            $c();
        }
    }

}