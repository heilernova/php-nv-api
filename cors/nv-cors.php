<?php

namespace nv\api;

use mysqli;

define('NV_BODY_JSON','application/json');

class Cors
{
    private static string $contentType = 'application/json';

    public static function setTypeContent(string $type = NV_BODY_JSON):void
    {
        // $co =  mysqli_connect();
        // $co->query('')->fetch_all(MYS)
        self::$contentType = $type;
    }


    public static function load():void
    {
        $content_type = self::$contentType;

        header("Content-Type: $content_type");

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");
        header('Access-Control-Allow-Methods: *');
        
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
}