<?php
header("Access-Control-Allow-Origin:*");
header('Content-type: text/html; charset=utf-8');
mb_internal_encoding("UTF-8");
session_start();

define('HOME_DIR',dirname(__FILE__));
require_once HOME_DIR.'/route.php';
require_once HOME_DIR.'/config.php';
require_once HOME_DIR.'/application/core/action.php';
require_once HOME_DIR.'/application/core/domain.php';
require_once HOME_DIR.'/application/core/responder.php';
require_once HOME_DIR.'/libraries/database.php';
require_once HOME_DIR.'/libraries/token.php';
require_once HOME_DIR.'/libraries/parameters.php';

//$pdo = Database::connect();

$dsn = "mysql:host=".MYSQL_HOSTNAME.";dbname=".MYSQL_DBNAME;
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
);
$pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, $opt);

$stmt = $pdo->query('SELECT * FROM clients');
$row = $stmt->fetch();
print_r($row);
echo $row[name];

Route::start();

