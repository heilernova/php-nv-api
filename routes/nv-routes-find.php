<?php
namespace nv\api;

/**
 * @author Hieler Nova
 */
function nv_routes_find(string $http_url, array $routes):Route|null
{
    $order_routes = function($a, $b){ return (strcmp($b->url, $b->url)); };

    uasort($routes, $order_routes);

    $url_items = explode('/', $http_url);
    $url_items_num = count($url_items);

    $filer_rutes = array_filter($routes, function(Route $route) use ($url_items, $url_items_num, $http_url){

        if ($route->urlItemsNum == $url_items_num){

            $valid = true;
            foreach ($route->indexControllers as $index) {

                if ($route->urlItems[$index] == $url_items[$index]){

                    $route->httpRequest = $http_url; $valid = true;

                }else{

                    $valid = false;
                }
            }

            return $valid;

        }else{

            return false;

        }

    });

    return array_shift($filer_rutes);
}