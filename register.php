<?php

// Include dal file
require_once "model/UserModel.php";

?>


<!DOCTYPE html> 



<html lang="en">

    <html>
        <head>
            <title>Login Page</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/cssLogin.css">
            <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
            <script src="https://kit.fontawesome.com/13fe68c0fc.js" crossorigin="anonymous"></script>
        </head>
        <body>

            <div class="wrapper">
            <form action="controller/controllerRegistar.php" method="post">
                
              <div class="container1">
                <div class="form-group">
                    <input type="text" placeholder="Indicar Nome" name="name">
                </div>

                <div class="form-group">
                    <input type="text" name="email" placeholder="Introduzir Email">
                </div> 


                <div class="form-group">
                    <input type="password"  name="senha" placeholder="Introduzir Password">
                </div>

                <div class="form-group">
                    <input type="password"  name="confirm_senha" placeholder ="Confirmar Password" >
                </div>
               
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submeter">
                </div>
                
                  <h3>Já possui conta? <a href="login.php">Faça login por aqui</a></h3>
            </div>
            </form>
                  </div> 
             </div> 
        </body>
    </html> 