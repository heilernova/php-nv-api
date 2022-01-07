<?php
namespace nv\database;

use function nv\api\nv_api_error_log;
use function nv\nv_load_data_class;

/**
 * @author Heiler Nova.
 */
class nvObjectDb
{
    public function __construct(array $data)
    {
        
        $keys_undefined = []; // Parametros indefinidos
        $keys_invalid = []; // Parametros cuyo datos no coinciden con su tipo

        foreach($this as $key=>$value){
            if (array_key_exists($key, $data)){
                
                try {
                    $this->$key = $data[$key];
                } catch (\Throwable $th) {
                    $keys_invalid[] = "$key : " . gettype($this->$key) . " <> " . gettype($data[$key]);
                }

            }else{
                $keys_undefined[] = $key;
            }
        }

        if ($keys_undefined || $keys_invalid){
            nv_api_error_log([
                'Error al cargar la clase DB',
                'Parametros faltantes:',
                $keys_undefined,
                'Parametros invalidos',
                $keys_invalid
            ]);
        }
    }
}