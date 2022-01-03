<?php
namespace nv\api\https;

use ReflectionMethod;

use function nv\api\response;

/**
 * @author Heiler Nova
 */
class nvHttpController
{
    /** Almacena el contenido del body convertido del formato JSON */
    protected mixed $body = null;

    public function __construct()
    {
        // Obtenemos y almacenamos en la variable $body el contendio del boyd de la peticion http
        $this->body = json_decode(file_get_contents('php://input'));

        // validamos is exitem el model
        $controller = str_replace('Controller', 'Model', $this::class);
        //response($controller);
        $this->model =  new $controller();
    }

    /**
     * Ejectua el método http solicitado por el cliente.
     * @param array $params Parmaetros ingresados en la url
     */
    public function execute(?array $params):void
    {
        // Obtenemos el método de la petición http.
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        // Validamos que el método este soportado por el controlador http
        if (method_exists($this, $method)){

            $ref = new ReflectionMethod($this, $method);

            $params_number = $ref->getNumberOfParameters();
            $params_number_required =$ref->getNumberOfRequiredParameters();
            $num_params = $params ? count($params) : 0;

            if ($params_number == $num_params || $params_number_required == $num_params){
                
                if ($params_number == 0){
                    $this->$method();
                }else{
                    $ref->invokeArgs($this, $params);
                }

            }else{
                response(['Error de parametros del cliente [ url ]'], $params_number, $params);
            }

        }else{

            // En caso de que el metodo no exista en la base de datos.
            response('Método no soportado', 405);

        }

    }
}