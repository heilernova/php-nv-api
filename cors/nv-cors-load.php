<?php
namespace nv\api;

function nv_cors_load(string $content_type = 'application/json', string $headers = null,string $origins = null,string $methods = null)
{
    header("Content-Type: $content_type");

    if ($origins) header("Access-Control-Allow-Origin: $origins");
    if ($headers) header("Access-Control-Allow-Headers: $headers");
    if ($methods) header("Access-Control-Allow-Methods: $methods");
    
    // ------------------------ CORS

    if (isset($_SERVER['HTTP_Origin'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_Origin']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: *");
    
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        exit(0);
    }
}