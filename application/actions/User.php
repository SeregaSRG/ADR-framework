<?php
class Action_User extends Action {

    function __construct() {
        $this->domain = new Domain_User();
        $this->responder = new Responder();
    }

    function login() {
        $this->domain->login();
        Responder::send([
            'token' => $_SESSION['now_user'][token]
        ]);
    }

    function register() {
        
    }
}

//$qwe = Post::get('qwe');
 