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
        $model = str_replace('Controller', 'Model', $this::class);
        
        try {
            //response($controller);
            $this->model =  new $model();
        } catch (\Throwable $th) {
            //throw $th;
        }

    }




    /**
     * Ejectua el método http solicitado por el cliente.
     * @param array $params Parmaetros ingresados en la url
     */
    public function execute(?array $params, string $custom_method = ''):void
    {
        // Obtenemos el método de la petición http.
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        $method .= ucfirst($custom_method);

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
                    if ($num_params > 0){
                        $ref->invokeArgs($this, $params);
                    }else{
                        $this->$method();
                    }
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