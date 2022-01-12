<?php
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
}