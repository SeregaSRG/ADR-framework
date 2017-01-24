<?php
class Action_Location extends Action {

    function __construct() {
        $this->domain = new Domain_Location();
        $this->responder = new Responder();
    }

    function add() {
        
    }
}