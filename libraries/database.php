<?php
class Database{
    
    static function connect_old(){
        $connection = new mysqli(MYSQL_HOSTNAME,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DBNAME);
        if($connection -> connect_errno){
            Responder::error($connection->connect_error);
            exit;
        } else {
            return $connection;
        }
    }

    static function connect() {
        $dsn = "mysql:host=".MYSQL_HOSTNAME.";dbname=".MYSQL_DBNAME;
        $opt = array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        );
        return $pdo = new PDO($dsn, MYSQL_USERNAME, MYSQL_PASSWORD, $opt);
    }

}