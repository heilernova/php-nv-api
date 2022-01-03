<?php
namespace nv\database;

/**
 * Arama un comandos sql a partir de los parametros ingresados.
 * para ejecutar en una cosulta preparada.
 * @author Heiler Nova
 * @param array $params Array de los fields a del insert.
 * @param string $table nombre de la tabla a la cual se le aplicacar la inserción
 * @return string 
 */
function nv_db_stmt_sql_insert(array $params, $table):string
{
    $fields = array_reduce($params, function($carry, $item){
        $carry .= ", $item";
        return $carry;
    });

    $fields = ltrim($fields, ', ');
    $values = ltrim(str_repeat(", ?", count($params)), ", ");

    return "INSERT INTO $table($fields) VALUES($values)";
}