<?php
namespace nv\api;

use mysqli_result;

class DatabaseResult
{
    public int $insertId = 0;
    public int $affetedRows = 0;
    public mysqli_result|bool $result = false;
    public string $sqlCommand = '';
    public array|null $sqlParams = null;
}