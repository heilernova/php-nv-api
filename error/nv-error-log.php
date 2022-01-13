<?php
namespace nv\api;

use Throwable;

function nv_error_log(array $messsage, Throwable $throwable = null, mixed $body =  null, $response_code = 500):void
{
    if (!$body) $body = 'Internal server error';
    
    $json = [
        'information'=>[
            'timeZone'=>date_default_timezone_get(),
            'date'=>date('c', time())
        ],
        'clientInformation'=>[
            'ip'=>'',
            'device'=>0
        ],
        'http'=>[
            'httpUrl'=>$_GET['url'],
            'httpRequestMethod'=>$_SERVER['REQUEST_METHOD']
        ],
        'messages'=>$messsage
    ];

    if ($throwable){

        $msg = $throwable->getTrace();
        $json['throwable'] = [
            'code'=>$throwable->getCode(),
            'file'=>$throwable->getFile(),
            'line'=>$throwable->getLine(),
            'trace'=>$throwable->getTrace()
        ];
    }

    $dir_errors =  $_ENV['nv-path-errors'];
    
    if (!file_exists($dir_errors)){
        mkdir($dir_errors);



        
    }
    
    // response($dir_errors);
    $numbers_of_file =  count(glob("$dir_errors{*.json}", GLOB_BRACE));
    $name_file =  date('Y-m-d', time()) . ' - ' . sprintf("%03d", $numbers_of_file);

    $file = fopen("$dir_errors/$name_file.json", 'a+');

    fputs($file, json_encode($json,0));

    fclose($file);
    http_response_code($response_code);
    echo "Internal server error";
    exit;
}