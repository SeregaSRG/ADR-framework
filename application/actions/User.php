<?php
class Action_User extends Action {

    function __construct() {
        $this->domain = new Domain_User();
        $this->responder = new Responder();
    }

    function login() {
        $this->domain->login();
        if(  ) {
            Responder::send('');
        }
    }

    function register() {

    }
}

//$qwe = Post::get('qwe');
 