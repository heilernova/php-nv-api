<?php
namespace nv\api;

/**
 * @author Heiler Nova
 */
class Api
{

    public Cors $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    /**
     * Inicia la aplicación mediante al url enviada por el cliente.
     * @param string $url Url corresponiente a la petición http.
     */
    public function run(string $url, bool $cors = false):void
    {
        if ($cors) $this->cors->load();

        if (!empty($url)){
        
            $route = Routes::find($url);

            if ($route){

                $controller = $route->getController();
                $controller->execute($route->getParams());
            }else{
                response("url undefined", 404);
            }


        }else{
            response('url empty', 404);
        }
    }


    /**
     * Cargamos las configuraciones de entorno del sistema.
     */
    public function loadSettings(string $path):void
    {
        try {

            $settings = json_decode(file_get_contents($path));
    
            define('NV_API_DB_HOSTNAME', $settings->connectionData->hostname ?? '');
            define('NV_API_DB_USERNAME', $settings->connectionData->hostname ?? '');
            define('NV_API_DB_PASSWORD', $settings->connectionData->hostname ?? '');
            define('NV_API_DB_DATABASE', $settings->connectionData->hostname ?? '');
    
            define('NV_API_PATH_HTTPS', $settings->paths->https ?? 'https/');
            define('NV_API_PATH_TABLES', $settings->paths->tables ?? 'db/');
            define('NV_API_PATH_ERRORS', $settings->paths->errors ?? 'errors/');

        } catch (\Throwable $th) {

            $msg = [
                'Error al establecer las configuraciones del sistema',
                $th
            ];

            nv_api_error_log($msg);

        }

    }
}