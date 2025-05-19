<?php

require_once '../model/UserModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $confirm_senha = $_POST["confirm_senha"];

    // Validate the form data
    $errors = [];

// Validate name
    if (empty($name)) {
        $errors[] = "Name is required.";
    }

// Validate email
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

// Validate password
    if (empty($senha)) {
        $errors[] = "Password is required.";
    } elseif (strlen($senha) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

// Validate confirmed password
    if (empty($confirm_senha)) {
        $errors[] = "Confirm password is required.";
    } elseif ($senha !== $confirm_senha) {
        $errors[] = "Passwords do not match.";
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
        $userModel->registerUtilizador($email, $name, $senha);
        
        // Redirect to login page

        exit();
    }
   
}
?>