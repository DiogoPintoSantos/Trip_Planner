<?php

if (!isset($_SESSION)) {
    session_start();
}

require_once '../model/UserModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] === 'form1') {
        // Process Form 1
        // Retrieve form data
        $pontoChegada = $_POST["pontoChegada"];
        $pontoPartida = $_POST["pontoPartida"];
        $matriculaCarro = $_POST['matriculaParaViagem'];
        $tipoViagem = $_POST["tipoViagem"];

        // Validate the form data
        $errors = [];

        // Validate pontoChegada
        if (empty($pontoChegada)) {
            $errors[] = "Ponto de chegada é obrigatório.";
        }

        // Validate pontoPartida
        if (empty($pontoPartida)) {
            $errors[] = "Ponto de partida é obrigatório.";
        }

        // Validate tipoViagem
        if (empty($tipoViagem) || !in_array($tipoViagem, ['economica', 'rapida'])) {
            $errors[] = "Tipo de viagem inválido.";
        }

        // Display errors or perform further operations
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        } else {
            // Process the data or perform any required actions
            // ...
            $userModel = new UserModel();
            $userModel->registarViagens($pontoPartida, $pontoChegada, $matriculaCarro, $tipoViagem);

            // Redirect to planear.php
            header("Location: ../planear.php");
        }
    } elseif (isset($_POST['formEliminarViagem'])) {
        try {
            $userModel = new UserModel();
                $viagem_id = $_POST['formEliminarViagem'];
                $userModel->deleteViagens($viagem_id);
                header("Location: ../planear.php");
            
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['formVerViagem'])) {
        try {
            $userModel = new UserModel();
            $viagem_id = $_POST['formVerViagem'];
            $viagem = $userModel->getViagem($viagem_id);
            
            $_SESSION['resultados'] = $userModel -> calcularRota($viagem);
            header("Location: ../planear.php");
            
        } catch (Exception $e) {
            // Handle the exception if needed
            echo "Error: " . $e->getMessage();
        }
    }
}
