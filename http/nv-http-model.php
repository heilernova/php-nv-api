<?php
namespace nv\api;

/**
 * @author Hieler Nova.
 */
class HttpModel
{
    public Database $database;

    public function __construct(Database $database = null)
    {
        if ($database){
            $this->database = $database;
        }else{
            $this->database =  nv_database_ini();
        }
    }

    protected function getQuery():DatabaseQuery
    {
        return $this->database->query;
    }

    protected function databaseCommit():bool
    { 
        return $this->database->commit();
    }
}