<?php
namespace nv\api\https;

use nv\database\Database;

class nvHttpModel
{
    public Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
}