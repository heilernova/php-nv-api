<?php
namespace test\https;

use nv\api\https\nvHttpController;

use function nv\api\response;

class PruebasController extends nvHttpController
{
    function get(){
        response('ok');
    }
}