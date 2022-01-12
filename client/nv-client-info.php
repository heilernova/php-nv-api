<?php
namespace nv\api;

require_once 'nv-client-get-device.php';
require_once 'nv-client-get-info.php';
require_once 'nv-client-get-ip.php';

class ClientInfo
{
    public string $ip = '';
    public int $device = 0;
}