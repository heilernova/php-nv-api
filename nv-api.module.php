<?php

require_once 'cors/nv-cors.php';
require_once 'nv-api.php';

require_once 'https/nv-body-response.php';
require_once 'https/nv-response.php';
require_once 'https/nv-http-controller.php';
require_once 'https/nv-http-model.php';

require_once 'router/nv-route.php';
require_once 'router/nv-routes.php';

// Funciones
require_once 'functions/nv-error-log.php';
require_once 'functions/nv-get-client-ip.php';
require_once 'functions/nv-load-data-class.php';

// Bases de datos
require_once 'database/nv-database-command.php';
require_once 'database/nv-database-result.php';
require_once 'database/nv-database.php';

require_once 'database/functions/nv-db-sql-insert.php';
require_once 'database/functions/nv-db-stmt-sql-insert.php';
require_once 'database/functions/nv-db-stmt-sql-update.php';


// Variables de entorno
$_ENV['NV_CORS_ACCESS-CONTROL-ALLOW-ORIGIN'] = '*';