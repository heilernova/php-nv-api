<?php
namespace nv\api;

function response(mixed $content_body = 'ok',int $response_code = 200)
{
    echo json_encode($content_body);
    http_response_code($response_code);
    exit;
}