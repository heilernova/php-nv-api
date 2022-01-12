<?php
namespace nv\api;

class ObjectDatabase
{
    public function __construct(array $data_row, bool $strict = true)
    {
        $keys_undefine = [];
        foreach ($this as $key=>$value){
            if (array_key_exists($key, $data_row)){
                $this->key = $data_row[$key];
            }else{
                $keys_undefine[] = $key;
            }
        }

        if (count($keys_undefine) > 0){
            $message = [
                'Failed to initailze object: ' . $this::class,
                'Keys undefine',
                $keys_undefine
            ];
            nv_error_log([]);
        }
    }  
}