<?php
//Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="pt-PT">

    <head>
        <title>Afton´s Trip Planner</title>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/888a21103b.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
        <link rel="stylesheet" href="css/cssSite.css">

    </head>
    <body>

        <!--Barra-->
        <nav class="barra">
            <a class="barrabutton" href="#Home">HOME</a> 
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
        
        <div class="container">

            <img  class="big-img" src="images/1am.png" alt="Imagem acima">
            <div class="texto1"><h1>Afton's Trip Planner</h1></div>
            <img  class="small-img" src="images/estrelaR.png" alt="Imagem abaixo">
            <a class="button" href="verTabelaCarregadores.php">Carregadores</a>

        </div>


        <footer>
            <p>&copy; 2023 Afton's Trip Planner. Todos os direitos reservados.</p>
        </footer>

</html>

