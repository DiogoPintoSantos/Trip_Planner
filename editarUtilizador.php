<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once "model/UserModel.php";

// Access the array of values
if (isset($_SESSION['userID'])) {

    $userModel = new UserModel();
    $utilizadorData = $userModel->getUtilizador($_SESSION['userID']);
} else {
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
        <link rel="stylesheet" href="css/cssEditarUtilizador.css">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
        <script src="https://kit.fontawesome.com/13fe68c0fc.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <div class="wrapper">
            <form action="controller/controllerPerfil.php" method="POST">
                <input type="hidden" name="formEditarUtilizador" value="form5">

                <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">
                <div class="container4">
                    <div class="form-group">
                        <label for="nome">Nome:</label>

                        <input type="text" name="nome" value="<?php echo $utilizadorData['nome']; ?>"><br>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>

                        <input type="text" name="email" value="<?php echo $utilizadorData['email']; ?>"><br>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
            </form>
        </div>
    </body>
</html>
