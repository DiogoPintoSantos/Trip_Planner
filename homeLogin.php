<?php
//Initialize the session
if (!isset($_SESSION)) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        header("Location: login.php");
        exit;
    } elseif (isset($_POST['register'])) {
        header("Location: register.php");
        exit;
    }
}
?>
<html>
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/cssLogin.css">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
        <script src="js/global_js.js"></script>
        <script src="js/login_js.js"></script>
        <script src="https://kit.fontawesome.com/13fe68c0fc.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="container2">
            <img src="images/2am.png" alt="Imagem" class="image">

            <div class="slogan-box"><p class="slogan">Connosco chega sempre ao seu destino</p></div>
            <div class="button-container">
                <form method="POST">
                    <input type="submit" name="login" class="btn btn-primary1" value="LOGIN" >
                    <input type="submit" name="register"class="btn btn-secondary ml-21" value="REGISTAR" >
                </form>
            </div>
        </div>
    </body>
</html>
