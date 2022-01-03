<?php

namespace nv\database;

/**
 * Genera un sql update apartir de los parametros ingresados
 * @param array $params Array de los los parametros donde la key del item es el fields del campo
 * @param array $condition Array de la condicion donde el primer itme es el sql condition en donde, 
 * y para definir un parametro se usa "?"
 * @param string $table Nombre del tabal a la cual se le realizara la actualización.
 * @return string Retorn la sql generado.
 */
function nv_db_stmt_sql_update($params, array $condition, $table)
{
    $condition_where = 0;

    $values = array_reduce($params, function($carry, $item){
        $carry .= ", $item=?";
        return $carry;
    });

    $values .= ltrim($values, ", ");

    return "UPDATE $table SET $values WHERE $condition_where";

}