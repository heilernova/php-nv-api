<?php
namespace test;

use nv\api\Main;
use nv\api\Routes;

require_once '../nv.module.php';

$settings = json_decode(file_get_contents('test.json'), true);

$main = new Main($settings);

$main->setHeaders('*');
$main->setMothods('*');
$main->setOrigin('*');

// Definimos rutaas
Routes::add('test', TestController::class);
Routes::add('test/{name:string}', TestController::class);

$main->setRoutes(Routes::getRoutes());

$main->run($_GET['url']);