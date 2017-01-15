<?php
header('Content-type: text/html; charset=utf-8');
header("Access-Control-Allow-Origin:*");
mb_internal_encoding("UTF-8");

session_start();

require_once 'config.php';
require_once 'application/core/action.php';
require_once 'application/core/domain.php';
require_once 'application/core/responder.php';
require_once 'route.php';

Route::start();



$mysqli = Base::connect();

$response = new Response();
