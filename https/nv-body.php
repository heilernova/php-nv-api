<?php
namespace nv\api;

use function nv\nv_load_data_class;

class nvBody
{
    public function __construct(object|array|null $body)
    {
        if ($body){
            $result = nv_load_data_class($this, $body);

            if ($result){
                $message = [];

                if ($result[0]){
                    $message[] = 'Faltan parametros por ingresar en la url';
                    $message = array_merge($message, $result[0]);
                }

                if ($result[1]){
                    $message[] = 'Parametros con el tipo de datos erronea';
                    $message = array_merge($message, $result[1]);
                }

                nv_api_error_log($message, 400, "Parrams error -");
            }
        }else{
            
            $messages = [
                'El valor del body  es nulo'
            ];

            nv_api_error_log($messages, 400, "Body required - empty");
        }
    }
}