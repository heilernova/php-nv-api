<?php
namespace nv\api\https;

use nv\database\Database;

use function nv\api\nv_client_get_device;
use function nv\api\nv_client_get_ip;

class nvHttpModel
{
    public Database $db;
    public string $clientIp = '';
    public int $clientDevice = 0;

    public function __construct()
    {
        $this->db = new Database();
        
        $this->clientIp = nv_client_get_ip();
        $this->clientDevice = nv_client_get_device();
    }
}