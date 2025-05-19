<?php
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

require_once "model/UserModel.php";
require_once 'model/sessionModel.php';

// Check if the user is logged in, if not then redirect him to login page
$session_model = new sessionModel();
$session_model->confirmLoggedIn();
?>


<!DOCTYPE html>
<html lang="pt-PT">

    <head>
        <title>Afton´s Trip Planner</title>
        <meta charset="UTF-8">
        <script src="https://kit.fontawesome.com/888a21103b.js" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
        <link rel="stylesheet" href="css/cssPerfil.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Exo&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>
    <body>

        <!--Barra-->
        <nav class="barra">
            <a class="barrabutton" href="Site.php">HOME</a> 
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

        <br><br><br><br><br><br><br><br>


        <div class="container">
            <section class="profile-section">
                <div class="profile-utilizador">
                    <?php
                    $userModel = new UserModel();
                    $result = $userModel->getUtilizador();

                    if ($result) {
                        
                        ?>
                        <h2>Perfil do Utilizador</h2>
                        <img src="images/mark.jpg" alt="Perfil 1" class="profile-picture">
                        <p><b><?php echo $result['nome']; ?></b></p>
                        <div class="basic-info">
                            <h3>Informações adicionais</h3>
                            <p>Email:<?php echo $result['email']; ?></p>
                        </div>
                        <form action="editarUtilizador.php" method="POST">
                            <input type="hidden" name="formGetUtilizadorForEditar" value="<?php echo $row['id']; ?>">
                            <button class="btn-alterar" type="submit">Editar</button>
                        </form>
                        <form action="controller/controllerPerfil.php" method="POST">
                            <input type="hidden" name="formEliminarUtilizador" value="<?php echo $row['id']; ?>">
                            <button class="btn-eliminar" type="submit">Eliminar</button>
                        </form>
                    <?php } else { ?>
                        <p>Erro ao obter os dados do perfil.</p>
                    <?php } ?>
                </div>
            </section>
            <img src="images/1am.png" alt="Logo" class="logo">
            <section class="profile-section">
                <div class="profile-card">

                    <?php
                    $userModel = new UserModel();
                    $result = $userModel->getCarro();

                    if ($result) {
                        ?>
                        <h2>Informações dos carros</h2>
                        <table>
                            <tr>
                                <th>Modelo</th>
                                <th>Matricula</th>
                                <th>Consumo Médio</th>
                                <th>Bateria</th>
                                <th>Autonomia</th>
                                <th>Velocidade Média</th>
                                <th>Opções</th>

                            </tr>

                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td><?php echo $row['modelo']; ?></td>
                                    <td><?php echo $row['matricula']; ?></td>
                                    <td><?php echo $row['consumoMedio']; ?></td>
                                    <td><?php echo $row['bateria']; ?></td>
                                    <td><?php echo $row['autonomia']; ?></td>
                                    <td><?php echo $row['velocidadeMedia']; ?></td>
                                    <td>
                                        <form action="controller/controllerPerfil.php" method="POST">
                                            <input type="hidden" name="formGetCarroForEditar" value="<?php echo $row['id']; ?>">
                                            <button class="btn-alterar" type="submit">Editar</button>
                                        </form>
                                        <form action="controller/controllerPerfil.php" method="POST">
                                            <input type="hidden" name="formEliminarCarro" value="<?php echo $row['id']; ?>">
                                            <button class="btn-eliminar" type="submit">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } else { ?>
                        <p>Erro ao obter os carros.</p>
                    <?php } ?>

                    <div class="actions">
                        <button id="redirect-button" onclick="window.location.href = 'carro.php';">Registe um carro</button>
                    </div>

                </div>
        </div>
    </section>
</div>
</div>
</body>
</html>


