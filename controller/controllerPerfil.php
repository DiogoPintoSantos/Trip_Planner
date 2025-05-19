<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once '../model/UserModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'form3') {

        // Retrieve form data
        $autonomia = $_POST["autonomia"];
        $bateria = $_POST["bateria"];
        $consumoMedio = $_POST["consumoMedio"];
        $matricula = $_POST["matricula"];
        $modelo = $_POST["modelo"];
        $velocidadeMedia = $_POST["velocidadeMedia"];
        $id = $_SESSION['userID'];
        // Validate the form data
        $errors = [];

// Validate name
        if (empty($autonomia)) {
            $errors[] = "Autonomia is required.";
        }

// Validate email
        if (empty($bateria)) {
            $errors[] = "Bateria is required.";
        }

// Validate password
        if (empty($consumoMedio)) {
            $errors[] = "Consumo medio is required.";
        }

// Validate confirmed password
        if (empty($matricula)) {
            $errors[] = "Matricula is required.";
        }

        if (empty($modelo)) {
            $errors[] = "Modelo is required.";
        }
        if (empty($velocidadeMedia)) {
            $errors[] = "Velocidade média is required.";
        }
// Display errors or perform further operations
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            $userModel = new UserModel();
            $userModel->registerCarro($autonomia, $bateria, $consumoMedio, $matricula, $modelo, $velocidadeMedia);

            header("Location: ../perfil.php");
        }
    } elseif (isset($_POST['formEliminarCarro'])) {
        try {

            $userModel = new UserModel();

            $id = $_POST['formEliminarCarro'];
            $userModel->deleteCarro($id);
            header("Location: ../perfil.php");
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['formGetCarroForEditar'])) {
        try {

            $userModel = new UserModel();
            $carro_id = $_POST['formGetCarroForEditar'];
            $_SESSION['carro'] = $userModel->getCarroByID($carro_id);
            header("Location: ../editarCarro.php");
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['formEditarCarro'])) {

        $carroID = $_POST['carro_id'];
        $modelo = $_POST['modelo'];
        $matricula = $_POST['matricula'];
        $consumoMedio = $_POST['consumoMedio'];
        $bateria = $_POST['bateria'];
        $autonomia = $_POST['autonomia'];
        $velocidadeMedia = $_POST['velocidadeMedia'];

        try {

            $userModel = new UserModel();

            $userModel->editarCarro($carroID, $modelo, $matricula, $consumoMedio, $bateria, $autonomia, $velocidadeMedia);
            header("Location: ../perfil.php");
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['formEditarUtilizador'])) {

        $utilizadorID = $_SESSION['userID'];

        $nome = $_POST["nome"];
        $email = $_POST["email"];

        try {

            $userModel = new UserModel();

            $userModel->editarUtilizador($nome, $email);
            header("Location: ../perfil.php");
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['formEliminarUtilizador'])) {
        try {

            $userModel = new UserModel();

            $userModel->deleteUtilizador($id);
            header("Location: ../controller/controllerLogout.php");
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    }
}
