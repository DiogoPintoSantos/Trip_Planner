<?php

require 'dal/Dal.php';

session_status() === PHP_SESSION_ACTIVE ? TRUE : session_start();

class controller {

    function __construct() {
        $this->objconfig = new config();
        $this->objsm = new sportsModel($this->objconfig);
    }

}
