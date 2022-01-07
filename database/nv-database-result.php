<?php
namespace nv\database;

use mysqli_result;

/**
 * @author Heiler Nova
 */
class DatabaseResult
{
    /** Ultimo id generado de la consulta sql */
    public int $insertId = 0;
    
    /** Número de filas afectadas de la ultima consulta sql */
    public int $affetedRows = 0;

    public string $errorMessage = '';
    public int $errorCode = 0;
    public string $sql_command = '';
    public ?array $sql_params = null;

    /** Resultado de la cosulta */
    public mysqli_result|bool $result = false;

}