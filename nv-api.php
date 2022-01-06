<?php
namespace nv\api;

/**
 * @author Heiler Nova
 */
class Api
{

    public Cors $cors;
    private static string $fileIdentifiquer = '';

    public function __construct()
    {
        $this->cors = new Cors();
    }

    /**
     * Inicia la aplicación mediante al url enviada por el cliente.
     * @param string $url Url corresponiente a la petición http.
     * @param bool $cors
     */
    public function run(string $url, bool $cors = false):void
    {
        if ($cors) $this->cors->load();

        if (!empty($url)){
        
            $route = Routes::find($url);

            if ($route){

                $controller = $route->getController();
                $controller->execute($route->getParams(), $route->method);
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

            define('NV_API_FILE_IDENTIFIQUER', self::$fileIdentifiquer);

            define('NV_API_DB_HOSTNAME', $settings->connectionData->hostname ?? '');
            define('NV_API_DB_USERNAME', $settings->connectionData->username ?? '');
            define('NV_API_DB_PASSWORD', $settings->connectionData->password ?? '');
            define('NV_API_DB_DATABASE', $settings->connectionData->database ?? '');
    
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

    /**
     * Establece el idenficar de los files, esta opcion se recomentiado cuando se tiene varias api
     * en un solo file.
     * @param string $name Texto por el cual iniciario los texto
     */
    public function fileIdentifiquer(string $name)
    {
        self::$fileIdentifiquer = $name;
    }
}