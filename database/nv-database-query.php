<?php
namespace nv\database;


class DatabaseQuery
{
    private Database $database;


    public function __construct(Database $database)
    {
        $this->database = $database;
       
    }

    public function insert($params, $table):bool
    {
        $sql = nv_db_stmt_sql_insert(array_keys($params), $table);

        return $this->database->execute($sql, $params);
        
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}