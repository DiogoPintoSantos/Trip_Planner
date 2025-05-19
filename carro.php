<?php
// Include dal file
require_once "model/UserModel.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['voltar'])) {
        header("Location: perfil.php");
        exit;
    }
}
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
                <form action="controller/controllerPerfil.php" method="post">
               <input type='hidden' name='form_type' value='form3'>
                    <div class="container3">
                        <div class="form-group">
                            <input type="text" placeholder="Indicar a autonomia" name="autonomia" >
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder=" Indicar a capacidade da bateria" name="bateria" >
                        </div>

                        <div class="form-group">
                            <input type="text" name="consumoMedio" placeholder="Indicar o consumo médio">
                        </div> 
                        <div class="form-group">
                            <input type="text" name="matricula" placeholder="Indicar a matricula">
                        </div> 
                        <div class="form-group">
                            <input type="text" name="modelo" placeholder="Indicar o modelo">
                        </div> 
                        <div class="form-group">
                            <input type="text" name="velocidadeMedia" placeholder="Indicar a velocidade média">
                        </div> 
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submeter">
                            <input type="reset" name="voltar" class="btn btn-secondary ml-2" value="Voltar" onclick="window.location.href = 'perfil.php';">

                        </div>
                </form>
            </div> 
        </div> 
</body>

</html>
