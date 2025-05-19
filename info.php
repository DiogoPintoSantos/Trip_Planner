<?php
//Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

require_once "model/UserModel.php";
// Check if the user is logged in, if not then redirect him to login page
?>

<html lang="pt-PT">

    <head>
        <title>Afton´s Trip Planner</title>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/888a21103b.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
        <link rel="stylesheet" href="css/cssInfo.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>

        <nav class="barra">
            <a class="barrabutton" href=Site.php>HOME</a> 
            <a class="barrabutton" href=planear.php>PLANEAR</a> 
            <a class="barrabutton" href=perfil.php>PERFIL</a> 
            <a class="barrabutton" href=info.php>INFO</a> 
            <?php
            if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                echo '<a class="barrabutton" href="controller/controllerLogout.php">LOGOUT</a>';
            } else {
                echo '<a class="barrabutton" href="login.php">LOGIN</a>';
            }
            ?>
        </nav>  


        <!-- About Container -->
        <div class="container">
            <div class="texto1"><h3>A nossa missão é certificarmo-nos que todos os condutores de carros elétricos cheguem ao seu destino.</h3></div>
            <div class="logo-container">
                <img src="images/1am.png" alt="Logo">
            </div>
            <div class="texto2"> <h3>Av. de Fernão de Magalhães 1647/59, 4350-170 Porto 1-888-329-3292327</h3></div>
        </div>

