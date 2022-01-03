<?php

use nv\api\api;

require_once '../nv-api.module.php';
require_once 'test.routes.php';

$main = new Api();

// Cargamos las configuraciones del sistema.
$main->loadSettings('settings.json');

// Corremos la aplicación
$main->run($_GET['url'], true);