<?php
class Responder {
    
    function __construct() {
    }

    static function send($struct = null){
        echo json_encode(array('status' => 'done','data' => $struct));
    }
    
    static function error($errorCode = null){
        echo json_encode(array('status' => 'error','errorcode' => $errorCode));
    }
}