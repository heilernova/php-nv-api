<?php
namespace nv\api;

/**
 * Obtiene la ipv4 del cliente que realiza la petición http.
 * @return string La dirección ip del cliente
 */
function nv_client_get_ip():string
{
    return $_SERVER['HTTP_CLIENT_IP'] ?? ( $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR']);
}