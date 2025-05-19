<?php

class sessionModel {

    public function confirmLoggedIn() {
        // Verifica se não tem sessão iniciada
        if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"]) {
            header("location: login.php");
            exit();
        }
    }

    public function confirmLoggedOut() {
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
            header("location: Site.php");
            exit();
        }
    }

    public function closeSession() {
        session_start();
        session_destroy();
        header("Location: ../login.php");
        exit();
    }

}
