<?php
namespace nv;

/**
 * Genera un token
 * @param int $long Número de carateres que poseera el token, por default es 50
 */
function nv_token_generate(int $long = 50)
{
    if ($long < 4) $long = 4;
 
    return bin2hex(random_bytes(($long - ($long % 2)) / 2));
}