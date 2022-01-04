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




    /** Inicaliza la clase y carga lo valores con los parametro ingresados. */
    function __construct(
        public string $url = '',
        /** Controlador asociado a la ruta */
        public string $nameSpaceController = '',
    )
    {

        // Separamos la url un array con los valor ingresados.
        $this->urlArray = explode('/', $url);

        // Almacenamos el número de elementos de un array crado apartir de la url designada para la ruta.
        $this->num = count($this->urlArray);

        // Almacensomas los indeces de la parametros de la url.
        $result = array_reduce($this->urlArray, function($carry, $item){ 
            
            static $i = 0;
            $carry[0] = []; // parametrops
            $carry[1] = []; // Controladores
            
            if (str_starts_with($item,  ':')) 
            {
                $carry[0][] = $i; // Paramentros
            }
            else
            {
                $carry[1][] = $i; // Controles
            }

            $i++;

            return $carry;
        });

        // echo json_encode($result); exit;

        $this->indexParams = $result[0];
        $this->indexControllers = $result[1];
    }




    /**
     * Obtene los parametros de la url
     * @return array|null retorna un array de los parametros de la url, en caso de no tener parametros retrona nunlo.
     */
    public function getParams():?array
    {
        // Separamos en un array la url inviado por el cliente
        $array = explode('/', $this->httpRequest);

        // recorresmos el array del index de los params
        $params = array_reduce($this->indexParams, function($carry, $item) use ($array){

            var_dump($this->urlArray); exit;
            $type = ltrim($array[$item], ':');

            $carry[] = match ($type){
                'int' => (int)$array[$item],
                'float' => (float)$array[$item],
                default => $array[$item]
            };

            return $carry;
        });

        return $params;

    }





    /**
     * Obtiene el controlador asociado a la url
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
            
            $controller_file = NV_API_FILE_IDENTIFIQUER . $controller_file;

        

            $file = NV_API_PATH_HTTPS .  "$controller_dir/$controller_file" . '.php';
    
            $file = str_replace('-controller', '.controller', $file);
            require_once $file;
            
            $namespace = $this->nameSpaceController;
    
            return new $namespace();
    
        }
        catch (\Throwable $th){
            nv_api_error_log(['Problemas con el llamado del del controlador', $th]);
        }
    }
}