<?php
namespace nv\api;

function nv_api_require_db(string $name){
    try {
        require_once "db/" . NV_API_FILE_IDENTIFIQUER . $name . ".php";
    } catch (\Throwable $th) {
        nv_api_error_log(['Error con nv_api_require_db', $th]);
    }
}