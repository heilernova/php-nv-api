<?php
namespace nv\api;

/**
 * Registra los errores internor de la ejecucion los almacene en ficheros independeintes
 * dentro del directorio definido por defecto este directorio se llama errors;
 * En caso de que el directorio no exista se creara uno con el nombre establecido.
 * @author Heiler Nova
 * @param array $error_messages Cada item del array representa una linea en el fichero que en el
 * cual se guardara el mensaje.
 * @param int $http_response_code Código de estado http por defecto es 500
 * @param mixed $body el valor ingresado sera convertido a formato JSON
 */
function nv_api_error_log(array $error_messages, int $http_response_code = 500, mixed $body = "Error interno del servidor")
{


     // Definimos las lineas para el registro del error
     $lines = [
        'Fecha UTC: ' . date('Y-M-d h:m:s A') . "\n\n",
        ...$error_messages
    ];
    
    $path = NV_API_PATH_ERRORS;

    // Si el direcctorio no existe se creara uno en la raiz de la ejcución
    if (!file_exists($path)){
        mkdir($path);
    }

    $numbers_of_file = count(glob('errors/{*.txt}', GLOB_BRACE)); // Obtenemos el numero de archivos.

    $name = date('Y-m-d', time()) . ' - ' . sprintf("%03d", $numbers_of_file); // establecemos el nombre del archivo.

    $file = fopen("$path/$name.txt",'a+');

    foreach($lines as $item){

        if (is_array($item)){

            foreach($item as $sub_item){

                if (is_array($sub_item)){
                    
                    foreach ($sub_item as $sub_sub_item){

                        fputs($file, "\t\t- $sub_item\n");

                    }

                }else{

                    fputs($file, "\t- $sub_item\n");

                }
            }

        }else{
            
            fputs($file, "$item\n");

        }
    }

    fclose($file); // cerrarmos el fichero

    // Notificamos al administrador del error

    //error_log('Error de ejecucion interno del servidor revisar archivo ' . $name);
    
    echo json_encode($body);
    http_response_code($http_response_code);
    exit(0);

}