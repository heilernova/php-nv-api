<?php
namespace nv\api;

/**
 * @author Heiler Nova
 * @param string $database_name Nombre de la base de datos para buscarla en los settings
 */
function nv_database_ini(string $database_name = null):Database
{
    if (!$database_name) $database_name = $_ENV['nv-database-default'];

    if (isset($_ENV['nv-settings']['database'][$database_name])){
        $database = $_ENV['nv-settings']['database'][$database_name] ?? $_ENV['nv-settings']['database']['default'];
        return new Database($database['hostname'], $database['username'], $database['password'], $database['database']);
    }else{
        nv_error_log([
            'No se encontro la información de la base de datos en settings',
            'Nombre:' . $database_name
        ],null, 'Database information empty');
    }
}