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
        $this->urlArray = explode('/', $url);
        $this->num = count($this->urlArray);

        $this->indexParams = array_reduce($this->urlArray, function($carry, $item){ 
            
            static $i = 0;
            
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

    }




    /**
     * Obtene los parametros de la url
     * @return array|null retorna un array de los parametros de la url, en caso de no tener parametros retrona nunlo.
     */
    public function getParams():?array
    {

        $array = explode('/', $this->httpRequest);

        $params = array_reduce($this->indexParams, function($carry, $item) use ($array){

            $type = ltrim($this->urlArray[$item], ':');

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