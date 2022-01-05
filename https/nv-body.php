<?php
namespace nv\api;

use function nv\nv_load_data_class;

class nvBody
{
    public function __construct(object|array|null $body)
    {
        if ($body){
            $body = (array)$body;

            $keys_invalid = [];
            $keys_undefine = [];

            foreach ($this as $key=>$values){
                if (array_key_exists($key, $body)){
                    try {
                        $this->$key = $body[$key];
                    } catch (\Throwable $th) {
                        //throw $th;
                        $keys_invalid[] = $key;
                    }
                }else{
                    $keys_undefine[] = $key;
                }
            }

            if($keys_invalid || $keys_undefine){
                nv_api_error_log(['Error con los parametros:', 'Indefinida:', ...$keys_undefine, 'Invalidas',... $keys_invalid], 400, "Error con los parametros del cliente");
            }

        }else{
            
            $messages = [
                'El valor del body  es nulo'
            ];

            nv_api_error_log($messages, 400, "Body required - empty");
        }
    }
}