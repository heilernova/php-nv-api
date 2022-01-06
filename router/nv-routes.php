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
         * @param string $custom_method Método personalizada a ejecutar.
         */
        public static function add(string $route, string $name_space_controller, string $custom_method = ''):void
        {
            self::$routes[] = new Route($route, $name_space_controller, $custom_method);
        }


        /**
         * Buscar en las rutas definidas una que concierde con la petición http que concuerede
         * @param string $url URL de la petición http realizada por el cliente.
         * @return Route|null retorna null en caso de que la ruta no este definida.
         */
        public static function find(string $url):Route|null
        {

            $so = function($a, $b) { return (strcmp ($b->url, $a->url));    };

            uasort(self::$routes, $so);


            // Limpiamos la url quitando los "/" de los extemos del string $url
            $url = trim($url, '/');

            // Separamamos la url
            $url_array = explode('/', trim($url,  '/'));

            // Contamos el número de items del array
            $num = count($url_array);

            // Filatramos la rutas que concuerdan con la url de la petición http
            $filter_urls = array_filter(self::$routes, function(Route $route) use ($num, $url_array, $url){

                if ($route->num == $num){

                    $valid = true;

                    foreach($route->indexControllers as $index_controller){

                        if ($route->urlArray[$index_controller] != $url_array[$index_controller]){
                            $valid = false;
                        }else{
                            // Cuadno de encuentre una igualdad de detendra el ciclo
                            $route->httpRequest = $url;
                        }

                    }

                    return $valid;

                }else{

                    return false;

                }
            });

            return array_shift($filter_urls) ?? null;
        }
}