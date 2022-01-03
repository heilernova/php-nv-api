<?php
namespace nv\api\https;

class BodyResponse
{
    public mixed $data = null;
    public bool $status = false;
    public int $statusCode = 0;
    public array $messages = [];

}