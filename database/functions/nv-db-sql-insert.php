<?php
namespace nv\database;



function nv_db_sql_insert(array $params, string $table):string
{
    $fields = '';
    $values = '';

    foreach($params as $key=>$value){
        $fields .= ", $key";
        $values .= ", " . (is_numeric($value) ? $value : "'$value'"); 
    }

    return "INSERT INTO $table($fields) VALUES($values)";
}