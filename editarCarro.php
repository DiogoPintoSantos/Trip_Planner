<?php
if (!isset($_SESSION)) {
session_start();
}

require_once "model/UserModel.php";

// Access the array of values
if(isset($_SESSION['carro'])) {
    $carro = $_SESSION['carro'];
} else{
    die("Error");
}

?>

<!DOCTYPE html> 

<html lang="pt-PT">
    <head>
        <title>Login Page</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/cssLogin.css">
        <link rel="stylesheet" href="css/cssEditarCarro.css">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
        <script src="https://kit.fontawesome.com/13fe68c0fc.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="wrapper">
            <form action="controller/controllerPerfil.php" method="POST">
                <input type="hidden" name="formEditarCarro" value="form5">

                <input type="hidden" name="carro_id" value="<?php echo $carro['id']; ?>">
                <div class="container4">
                    <div class="form-group">
                        <label for="modelo">Modelo:</label>

                        <input type="text" name="modelo" value="<?php echo $carro['modelo']; ?>"><br>
                    </div>

                    <div class="form-group">
                        <label for="matricula">Matrícula:</label>

                        <input type="text" name="matricula" value="<?php echo $carro['matricula']; ?>"><br>
                    </div>

                    <div class="form-group">
                        <label for="consumoMedio">Consumo Médio:</label>
                        <input type="text" name="consumoMedio" value="<?php echo $carro['consumoMedio']; ?>"><br>
                    </div>

                    <div class="form-group">
                        <label for="bateria">Bateria:</label>
                        <input type="text" name="bateria" value="<?php echo $carro['bateria']; ?>"><br>
                    </div>

                    <div class="form-group">
                        <label for="autonomia">Autonomia:</label>
                        <input type="text" name="autonomia" value="<?php echo $carro['autonomia']; ?>"><br>
                    </div>

                    <div class="form-group">
                        <label for="velocidadeMedia">Velocidade Média:</label>
                        <input type="text" name="velocidadeMedia" value="<?php echo $carro['velocidadeMedia']; ?>"><br>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
            </form>
        </div>
    </body>
</html>
