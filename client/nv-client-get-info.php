<?php
namespace nv\api;

/**
 * @author Heiler Nova.
 */
function nv_client_get_info():ClientInfo
{
    $client = new ClientInfo();
    $client->ip = nv_client_get_ip();
    $client->device = nv_client_get_device();
    
    return $client;
}