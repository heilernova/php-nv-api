<?php
namespace nv\api;

/**
 * @author Heiler Nova.
 */
class Routes
{
        /** Almacena las rutas, cada item es tipo nv\api\Route */
        private static array $routes = [];

        /**
         * Agrega una ruta a la api
         * @param string $rute Ruta para definir los parametro utilize ":" seguido del tipo de dato "int, float, string" 
         * Ejm. "test/:int" 
         * @param string $name_space_controller El namaspace del controlador Utilice el Controlador::class
         */
        public static function add(string $route, string $name_space_controller):void
        {
            self::$routes[] = new Route($route, $name_space_controller);
        }


        /**
         * Buscar en las rutas definidas una que concierde con la petición http que concuerede
         * @param string $url URL de la petición http realizada por el usuario.
         * @return Route|null retorna null en caso de que la ruta no este definida.
         */
        public static function find(string $url):Route|null
        {

            // Limpiamos la url quitando los "/" de los extemos del string $url
            $url = trim($url, '/');

            // Separamamos la url
            $array = explode('/', trim($url,  '/'));

            // Contamos el número de items del array
            $num = count($array);

            // Filatramos la rutas que concuerdan con la url de la petición http
            $filter_urls = array_filter(self::$routes, function(Route $route) use ($num, $array, $url){

                if ($route->num == $num){

                    $valid = true;

                    foreach($route->indexControllers as $index_controller){
                        if ($route->urlArray[$index_controller] != $array[$index_controller]){
                            $valid = false;
                        }else{
                            // Cuadno de encuentre una igualdad de detendra el ciclo
                            $route->httpRequest == $url;
                            // $valid = false;
                        }
                    }

                    return $valid;
                }else{
                    return false;
                }
            });
            // response(self::$routes);

            return array_shift($filter_urls) ?? null;
        }
}