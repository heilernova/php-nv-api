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
        
        $keys_undefined = [];

        foreach($this as $key=>$value){
            if (array_key_exists($key, $data)){
                
                try {
                    $this->$key = $data[$key];
                } catch (\Throwable $th) {
                    nv_api_error_log([
                        'Error al cargar el valor en la clase',
                        "Key = $key",
                        "Tipo de datos del parametro del objeto: $this->$key tipo de dato : " . gettype($this->$key),
                        "Tipo de datos de la db: $data[$key] tipo de dato :" . gettype($data[$key])
                    ]);
                }

            }else{
                $keys_undefined[] = $key;
            }
        }

        if ($keys_undefined){
            nv_api_error_log([
                'Falta parametros:',
                ...$keys_undefined
            ]);
        }
    }
}