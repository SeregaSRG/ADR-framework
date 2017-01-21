<?php
class Action_User extends Action {

    function __construct() {
        $this->domain = new Domain_User();
        $this->responder = new Responder();
    }

    function register() {
        $this->domain->register();

        if ($this->domain->isRegistered) {
            Responder::send([
                'code' => $this->domain->registeredCode
            ]);
        } else {
            Responder::error(
                $this->domain->registeredCode
            );
        }
    }

    function login() {
        $this->domain->login();

        if ($this->domain->isLogged) {
            Responder::send([
                'token' => $_SESSION['now_user'][token],
                'name'  => $this->domain->user->name,
                'surname'  => $this->domain->user->surname,
                'email'  => $this->domain->user->email
            ]);
        } else {
            Responder::error(
                $this->domain->loggedCode
            );
        }
    }

    function checkLogin() {
        $this->domain->checkLogin();
            
        if ($this->domain->isChecked) {
            Responder::send([
                'code' => $this->domain->checkedCode
            ]);
        } else {
            Responder::error([
                'code' => $this->domain->checkedCode
            ]);
        }
    }
}
