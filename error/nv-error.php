<?php
namespace nv\api;


class ErrorController
{
    static function rederIndex(){
        header('content-type: text/html; charset=utf-8');

        $path = $_ENV['nv-path-errors'];
        $dir = opendir($_ENV['nv-path-errors']);
        
        $list_errors = [];

        while ($elemento = readdir($dir)){
            // Tratamos los elementos . y .. que tienen todas las carpetas
            if( $elemento != "." && $elemento != ".."){
                // Si es una carpeta
                if( is_dir($path.$elemento) ){
                    // Muestro la carpeta
                    //echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                // Si es un fichero
                } else {
                    // Muestro el fichero
                    $list_errors[] = json_decode(file_get_contents("$path/$elemento"),true);
                }
            }
        }

        $list_errors;
        require 'nv-error-html.php';
    }

    static function clear(){
        $path = $_ENV['nv-path-errors'];
        $dir = opendir($_ENV['nv-path-errors']);

        while ($elemento = readdir($dir)){
            // Tratamos los elementos . y .. que tienen todas las carpetas
            if( $elemento != "." && $elemento != ".."){
                // Si es una carpeta
                if( is_dir($path.$elemento) ){
                    // Muestro la carpeta
                    //echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
                // Si es un fichero
                } else {
                    // Muestro el fichero
                    unlink("$path/$elemento");
                }
            }
        }

    }


    static function get(){
        
    }
}