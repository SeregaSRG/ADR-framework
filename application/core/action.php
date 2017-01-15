<?php
class Action {

    public $domain;
    public $responder;

    function __construct() {
        $this->domain = new Domain();
        $this->responder = new Responder();
    }
}