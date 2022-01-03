<?php

require_once 'cors/nv-cors.php';
require_once 'nv-api.php';

require_once 'https/nv-response.php';
require_once 'https/nv-http-controller.php';
require_once 'https/nv-http-model.php';

require_once 'router/nv-route.php';
require_once 'router/nv-routes.php';


// Variables de entorno
$_ENV['NV_CORS_ACCESS-CONTROL-ALLOW-ORIGIN'] = '*';