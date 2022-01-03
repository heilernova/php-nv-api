<?php
namespace nv\database;

use mysqli_result;

class DatabaseResult
{
    public int $insertId = 0;
    public int $affetedRows = 0;
    public mysqli_result|bool $result = false;

    public function __construct(mysqli_result|bool $result = null,int $insert_id = null, int $affeted_rows = null)
    {
        $this->result = $result ? $result : false;
        $this->affetedRows = $affeted_rows ? $affeted_rows : 0;
        $this->insertId = $insert_id ? $insert_id : 0;
    }
}