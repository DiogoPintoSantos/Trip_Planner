<?php 
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/cssLogin.css">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
    </head>
    <body>
        <div class="wrapper">
            <div class="container">
                <form action="controller/controllerLogin.php" method="post">
                    <img class="big-img" src="images/1am.png" alt="Imagem acima">
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="senha" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                    </div>
                    <h3>Não possui conta? <a href="register.php">Registe-se aqui</a></h3>
                </form>
            </div>
        </div>
    </body>
</html>

