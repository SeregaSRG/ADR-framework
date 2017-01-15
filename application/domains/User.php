<?php 
class Domain_User {
    
    public $isCorrectPassword;
    
    function login() {
        $password   = Parameters::Get('password');
        $phone      = Parameters::Get('phone');
    }

    function checkPassword($phone, $password) {
        global $mysqli;
        $clientInfoQuery = $mysqli->query("SELECT * FROM `clients` WHERE phone='".$phone."'");
        if (!$clientInfoQuery->num_rows){
            Response::error('202');
            exit();
        }
        $clientInfoObj = $clientInfoQuery->fetch_object();
        if ( hash_equals( $clientInfoObj->password, $password) ) {
            return true;
        } else {
            return false;
        }
    }
}