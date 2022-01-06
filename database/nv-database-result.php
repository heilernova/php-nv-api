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
    public string $sql = '';

    /** Resultado de la cosulta */
    public mysqli_result|bool $result = false;

    public function __construct(mysqli_result|bool $result = null,int $insert_id = null, int $affeted_rows = null, string $sql, string $error_message = '', int $error_code = 0)
    {
        $this->result = $result ? $result : false;
        $this->affetedRows = $affeted_rows ? $affeted_rows : 0;
        $this->insertId = $insert_id ? $insert_id : 0;
        $this->errorMessage = $error_message;
        $this->errorCode = $error_code;
        $this->sql = $sql;
    }
}