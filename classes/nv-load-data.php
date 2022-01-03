<?php
namespace nv\classes;

/**
 * Clase padre para mapear los varores de un array asociativo o un objeto
 * ya sea json a un objeto
 * @author Heiler Nova
 */
class nvLoadData
{
    public function __construct(array|object|null $data)
    {
        // try {
        //     //code...
        //     if ($data){
        //         // Extrameos el nombre de los porametros que contenga las clase hija que heredara este metódo
        //         $params = array_keys((array)$this);
        //         $params_data = (array)$data;

        //         $undefined_keys = [];
        //         $type_keys = [];

        //         foreach($params as $param_name){

        //             if (array_key_exists($param_name, $data)){

        //                 try {
        //                     $this->$param_name = $params_data[$param_name];
        //                 } catch (\Throwable $th) {
        //                     $type_keys[] = $param_name;
        //                 }

        //             }else{
        //                 $undefined_keys = $param_name;
        //             }

        //         }

        //         // En caso de que se cuentren llaves indefinidas en la data enviada.
        //         if ($undefined_keys || $type_keys){
        //             echo "Falta parametros";
        //         }

        //         // echo json_encode(array_keys((array)$this));
        //     }else{
        //         // En caso de los datos sea nulos
        //     }
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     // Manejo de los errores
        //     echo "Error de ejecución";
        //     echo $th;
        // }
    }
}