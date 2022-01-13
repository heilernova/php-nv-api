<?php
namespace nv\api;

require_once 'nv-http-body.php';
require_once 'nv-http-model.php';
require_once 'nv-http-response.php';
/**
 * @author Heiler Nova.
 */
class HttpController
{
    public Database $database;
    public array|string|bool|int|float|null $body;

    public function __construct()
    {
        $this->database = nv_database_ini();
        $this->body = json_decode(file_get_contents('php://input'), true);
    }
}