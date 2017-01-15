<?php
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin:*");
mb_internal_encoding("UTF-8");

session_start();

require_once 'config.php';
require_once 'route.php';













$mysqli = Base::connect();

$response = new Response();

$addressWithoutGet = explode('?',htmlspecialchars($_SERVER['REQUEST_URI'],ENT_QUOTES));
$addressPieces = explode('/',htmlspecialchars($addressWithoutGet[0],ENT_QUOTES));

switch($addressPieces[1]){
    case 'api':
        $groupandmethod = explode('.',htmlspecialchars($addressPieces[2],ENT_QUOTES));
        $group = $groupandmethod[0];
        $method = $groupandmethod[1];
        require_once HOME_DIR.'/api/'.$group.'/methods/'.$method.'.php';
        break;
}