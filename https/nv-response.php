<?php
namespace nv\api;

/**
 * Responde en formato JSON el valor que se ingrese en el body
 * @author Heiler Nova.
 * @param mixed $body Valor a repsonser.
 * @param int $http_response_code Códido de estado http
 */
function response(mixed $body, int $http_response_code = 200):void
{
    echo json_encode($body);
    http_response_code($http_response_code);
    exit(0);
}