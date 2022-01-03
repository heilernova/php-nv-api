<?php

use nv\api\https\nvHttpController;

use function nv\api\response;

class Pruebas extends nvHttpController
{
    function get(){
        response("Hola mundo");
    }
}