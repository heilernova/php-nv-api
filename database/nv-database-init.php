<?php
namespace nv\api;

function nv_database_ini(string $database_name = 'default'):Database
{
    $database = $_ENV['nv-settings']['database'][$database_name] ?? $_ENV['nv-settings']['database']['default'];
    
    return new Database($database['hostname'], $database['username'], $database['password'], $database['database']);
}