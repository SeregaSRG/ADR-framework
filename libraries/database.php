<?php
class Database{
    
    static function connect(){
        $connection = new mysqli(MYSQL_HOSTNAME,MYSQL_USERNAME,MYSQL_PASSWORD,MYSQL_DBNAME);
        if($connection -> connect_errno){
            Responder::error($connection->connect_error);
            exit;
        } else {
            return $connection;
        }
    }

}