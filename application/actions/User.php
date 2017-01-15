<?php
class Action_User extends Action {

    function __construct() {
        $this->domain = new Domain_User();
        $this->responder = new Responder();
    }

    function login() {
        $this->domain->login();
        if ($this->domain->isCorrectPassword) {
            Responder::send([
                'token' => $_SESSION['now_user'][token]
            ]);
        } else {
            Responder::error('202');
        }
        
    }

    function register() {
        
    }
}

//$qwe = Post::get('qwe');
 