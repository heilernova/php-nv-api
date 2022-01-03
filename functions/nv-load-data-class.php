<?php
namespace nv;

/**
 * Carga los datos de un array asociativo o un object a un clase definida.
 * @return null|array Si retorna un array es porque ocurreo un error al cargar los datos.
 * El primer elemento del array es un array de los parametros indefinidos y el segundo los parametos
 * de invalidas
 */
function nv_load_data_class(object $object, object|array $data):?array
{
    $data = (array)$data;

    $keys_object = array_keys((array)$object);
    
    $keys_undefined = []; // Parametros que no se encuentran el clase.
    $keys_invalid = []; // parametros cuyo valor no es valido

    foreach($keys_object as $key){

        if (array_key_exists($key, $data)){

            try {

                $object->$key = $data[$key];

            } catch (\Throwable $th) {

                $keys_invalid[] = $key;

            }

        }else{

            $keys_undefined[] = $key;

        }
        return ($keys_undefined ||$keys_invalid ) ? [$keys_undefined,$keys_invalid] : null;
    }
}