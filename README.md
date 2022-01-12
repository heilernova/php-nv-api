# php-nv-api

## Requerimientos del sistema
* PHP Version: 8.0

## Intalación

Duede realizar la descarga manualmente desde el repositorio de gihub, o descargarlos mediante consola,
en el proyecto

El código por cosnola
```git
git clone https://github.com/heilernova/php-nv-api;
```

## Creación del entorno
En la carpeta raíz se deben crear los sigientes elementos

3 archivos:
* .htaccess
* api.index.php. 
* api.json
* api.routes.php

Un directorio llamada https, el cual contendra los controladores.

### Código de los ficheros pirncipales

#### .htaccess
```htacsess
RewriteEngine On
RewriteRule ^(.*) test.index.php?url=$1 [L,QSA]
```
#### api.json
```json
{
    "paths":{
        "errors":"errors/",
        "https":"https/"
    },
    "database":{
        "default":{
            "hostname":"localhost",
            "username":"root",
            "password":"",
            "database":"ftc_registro_tirillas_post"
        }
    }
}
```
#### api.routes.php
```php

use nv\api\Routes;

Routes::add('test', TestController::class);
Routes::add('test/{name:string}', TestController::class);
Routes::add('test/{name:string}/list', TestController::class);

```
#### api.index.php
```php

use nv\api\Main;
use nv\api\Routes;

require_once '../nv.module.php';

$settings = json_decode(file_get_contents('test.json'), true);

$main = new Main($settings);

$main->setHeaders('*');
$main->setMothods('*');
$main->setOrigin('*');


$main->setRoutes(Routes::getRoutes());

$main->run($_GET['url']);
```
