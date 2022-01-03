<?php

namespace nv\database;

class DatabaseTable
{
    private string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function getInsert(array|object $fields):DatabaseCommand
    {
        $r = new DatabaseCommand();

        $r->params = $fields;
        $r->sql = nv_db_stmt_sql_insert($fields, $this->table);

        return $r;
    }
}