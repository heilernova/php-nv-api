<?php
namespace nv\api;

/**
 * @author Heiler Nova.
 */
class HttpController
{
    public Database $database;

    public function __construct()
    {
        $this->database = nv_database_ini();
    }
}