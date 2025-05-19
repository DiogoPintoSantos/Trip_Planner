<?php

require_once('../model/sessionModel.php');

if (!isset($_SESSION)) {
    session_start();
}

$sessionModel = new sessionModel();
$sessionModel->closeSession();
?>