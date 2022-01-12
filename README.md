# php-nv-api

## Requerimientos del sistema
* PHP Version: 8.0

## Instalación

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
            "database":"database"
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


## Cración de los controladores
Dentro del directorio https se alojaron los controladores
Para nombrara se debe dar el nombre mas .controller.php

Ejemplos
* Controlador TestController : Nombre del fichero => test.controller.php
* Controlador UserAddressControler : Nombre del fichero => user-address.controller.php

### Contendio del fichero

las funciones internas hacen referencia a los metodos que soporta el controlador asociada la ruta.
En caso no tener el un metod que solicita el cliente retornara error 405 Método no soportado por la url.

En este ejemple a url https://www.misito.com/api/test Soporta unicamente los métodos get, post y delete
```php
namespace test;

use nv\api\HttpController;

use function nv\api\response;

class TestController extends HttpController
{

    function get(){
        $result = $this->database->execute("SELECT * FROM tb_business")->fetch_all(MYSQLI_ASSOC);
        response($result);
    }

    function post(int $name, $id = null){
        response($name);
    }
    
    function delete(int $id){
        response('ok');
    }
}
```
