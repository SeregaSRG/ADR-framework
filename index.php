<?php
header("Access-Control-Allow-Origin:*");

session_start();

require_once 'config.php';
require_once 'application/core/action.php';
require_once 'application/core/domain.php';
require_once 'application/core/responder.php';
require_once 'route.php';

Route::start();

