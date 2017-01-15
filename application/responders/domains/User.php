<?php 
class Domain_User {
    
    public $isCorrectPassword;
    public $user;

    function login() {
        $password   = Parameters::Get('password');
        $phone      = Parameters::Get('phone');

        $this->getUserInfo($phone);
        
        $this->isCorrectPassword = $this->checkPassword($password);

        if ($this->isCorrectPassword) {
            $_SESSION['now_user']->token    = Token::generate();
            $_SESSION['now_user']->ip       = $_SERVER['REMOTE_ADDR'];
            $_SESSION['now_user']->id       = $this->user->id;

            Token::insert($_SESSION['now_user']->id, $_SESSION['now_user']->token,$_SESSION['now_user']->ip);

        }
    }

    function checkPassword($password) {
        if ( hash_equals( $this->user->password, crypt($password, SALT)) ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getUserInfo($phone) {
        global $mysqli;

        $userInfoQuery = $mysqli->query("SELECT * FROM `users` WHERE phone='".$phone."'");

        if (!$userInfoQuery->num_rows){
            // TODO
            Responder::error('202');
            exit();
        }

        $this->user = $userInfoQuery->fetch_object();
    }
}