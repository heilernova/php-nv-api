<?php
namespace nv\api;

use nv\api\https\nvHttpController;

/**
 * @author Heiler Nova
 */
class Route{

    /** Array de la url separadao por los "/" */
    public array $urlArray = [];

    /** Número de items de la array de la url */
    public int $num = 0;

    /** array de los index de la hubicacíon de los parametros en la url */
    public array $indexParams = [];

    /** array de los index de la hibicación de los controles */
    public array $indexControllers = [];

    /** Almacena la url de la peticion http del cliente */
    public string $httpRequest = '';

    /** Método personalizado */
    public string $method = '';

    /** Namespace del controlador asignado a la ruta */
    public string $nameSpaceController = '';

    /** Ruta asignada */
    public string $url = '';



    /** Inicaliza la clase y carga lo valores con los parametro ingresados. */
    function __construct(string $url = '', string $name_space_controller = '', string $custom_method = '')
    {

        try {

            // Separamos la url un array con los valor ingresados.
            $this->urlArray = explode('/', $url);

            // Almacenamos el número de elementos de un array crado apartir de la url designada para la ruta.
            $this->num = count($this->urlArray);

            // Almacensomas los indeces de la parametros de la url.
            $i = 0;
            foreach($this->urlArray as $item){
                if (str_starts_with($item, ':')){
                    $this->indexParams[] = $i;
                }else{
                    $this->indexControllers[] = $i;
                }
                $i++;
            }

            $this->url = $url;
            $this->nameSpaceController = $name_space_controller;
            $this->method = $custom_method;

        } catch (\Throwable $th) {
            
            $message = [
                'Error con el contructor del  Route',
                $th
            ];

            nv_api_error_log($message);

        }

    }




    /**
     * Get the url parameters
     * @return array|null returns an array of the url parameters, in case of not having parameters, it will return null.
     */
    public function getParams():?array
    {
        try {
            
            // We convert the url of the request into on array
            $array = explode('/', $this->httpRequest);

            // We go through the elements of the array
            $params = array_reduce($this->indexParams, function($carry, $item) use ($array){
                
                $type = ltrim($array[$item], ':');
                
                $carry[] = match ($type){
                    'int' => (int)$array[$item],
                    'float' => (float)$array[$item],
                    default => $array[$item]
                };
                
                return $carry;
            });

            return $params;


        } catch (\Throwable $th) {

            $message = [
                'Error al ejecuta getParams() de la clase Route',
                $th
            ];

            nv_api_error_log($message);
        }



    }





    /**
     * Gets
     * @return nvHttpController
     * @throws void En caso de error Detiene la ejecución, y registra los errores mediante el llamado de nv_error_log
     */
    public function getController():nvHttpController
    {
        try {

            $array_namespace =  explode('\\', $this->nameSpaceController);
            $controller_name = str_split(lcfirst(array_pop($array_namespace)));
    
            // Convertirmos el nombre del contrador a nombre del fichero
            $controller_file = array_reduce($controller_name, function($carry, $item){
                $carry.= ctype_upper($item) ? '-' . strtolower($item) : $item;
                return $carry;
            });
            
            $controller_dir = str_replace('-controller', '', $controller_file);
            $controller_file = str_replace('-controller', '.controller', NV_API_FILE_IDENTIFIQUER . $controller_file);
            
            $file = NV_API_PATH_HTTPS .  "$controller_file" . '.php';

            
            if (!file_exists($file)) $file = NV_API_PATH_HTTPS .  "$controller_dir/$controller_file" . '.php';
            
            require_once $file;
            
            $namespace = $this->nameSpaceController;
            
            return new $namespace();
    
        }
        catch (\Throwable $th){
            nv_api_error_log(['Problemas con el llamado del del controlador', $th]);
        }
    }
}