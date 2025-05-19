<?php
require_once '../model/UserModel.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Validate the form data
    $errors = [];

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

    // Display errors or perform further operations
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    } else {
        // Check if user exists in the database
        $userModel = new UserModel();
        $user = $userModel->checkUtilizador($email, $senha);
        
        // Initiate session
        if (!isset($_SESSION)) {
            session_start();
        }

        if ($user) {
            $_SESSION['loggedin'] = true;
            $userModel = new UserModel();
            $_SESSION['userID'] = $userModel->getUtilizadorID($email);
                    
            header("Location: ../Site.php");
            exit();
        } else {
            // User does not exist, display an error or redirect to a login error page
            echo "Invalid email or password.";
        }
    }
}
?>