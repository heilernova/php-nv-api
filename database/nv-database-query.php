<?php
namespace nv\database;

use function nv\api\response;

class DatabaseQuery
{
    private Database $database;


    public function __construct(Database $database)
    {
        $this->database = $database;
       
    }

    public function insert($params, $table):bool
    {
        $sql = nv_db_stmt_sql_insert(array_keys((array)$params), $table);
        //response([$params, $sql]);
        return $this->database->execute($sql, (array)$params);
        
    }

    public function update()
    {

    }

    public function delete(string $condition, array $params, string $table):bool
    {
        return $this->database->execute("DELETE FROM $table WHERE $condition", $params);
    }
}