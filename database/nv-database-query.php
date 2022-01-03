<?php
namespace nv\database;


class DatabaseQuery
{

    public function insert($params, $table):bool
    {
        $sql = nv_db_stmt_sql_insert($params, $table);
        
        return false;
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}