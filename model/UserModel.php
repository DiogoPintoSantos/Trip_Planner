<?php

class UserModel {

    //database name
    private $DB_NAME = 'afton';
    //host tipically is the localhost
    private $DB_HOST = 'localhost';
    //database username
    private $DB_USER = 'teste';
    //password for the username metioned 
    private $DB_PASS = '123456';
    private $link = null;

    public function __construct() {
        //open connection
        $this->link = new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASS, $this->DB_NAME);
        if (mysqli_connect_errno())
            return NULL;
    }

    public function closeConn() {
        // Close connection
        mysqli_close($this->link);
    }

    public function registerUtilizador($email, $nome, $senha) {
        // Prepare an insert statement
        $sql = "INSERT INTO utilizador (email, nome, senha) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($this->link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_email, $param_nome, $param_senha);

            // Set parameters   
            $param_email = $email;
            $param_nome = $nome;
            $param_senha = password_hash($senha, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: ../Login.php");
                exit();
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }

        // Display the error message if there was an issue with the execution
        if (isset($error_message)) {
            echo $error_message;
        }
    }

    public function checkUtilizador($email, $senha) {
        $sql = "SELECT id, email, senha FROM utilizador WHERE email = ?";
        $stmt = $this->existUtilizador($email);

        if ($stmt != null) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $id, $resultEmail, $hashedSenha);

            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($senha, $hashedSenha)) {
                    // Password verification successful
                    return true;
                } else {
                    // Incorrect password
                    return false;
                }
            } else {
                // User not found
                return false;
            }
        } else {
            // Error occurred
            return false;
        }
    }

    public function verificarLogin() {
        // Verifica se a variável de sessão "logged_in" está definida e é verdadeira
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            // Usuário fez login, pode prosseguir
            return true;
        } else {
            // Usuário não fez login, redireciona para a página de login
            header("Location: login.php");
            exit();
        }
    }

    public function existUtilizador($email) {
        $sql = "SELECT id, email, senha FROM utilizador WHERE email = ?";
        $stmt = mysqli_prepare($this->link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        return $stmt;
    }

    public function getUtilizador() {

        $id = $_SESSION['userID'];

        $sql = "SELECT * FROM utilizador WHERE id=?";
        $stmt = mysqli_prepare($this->link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = $result->fetch_assoc();

        return $row;
    }

    public function deleteUtilizador() {
        $utilizador_id = $_SESSION['userID'];

        $carro_sql = "DELETE FROM carro WHERE utilizador_id=?";
        $carro_stmt = mysqli_prepare($this->link, $carro_sql);
        mysqli_stmt_bind_param($carro_stmt, "i", $utilizador_id);
        mysqli_stmt_execute($carro_stmt);

        $viagem_sql = "DELETE FROM viagem WHERE utilizador_id=?";
        $viagem_stmt = mysqli_prepare($this->link, $viagem_sql);
        mysqli_stmt_bind_param($viagem_stmt, "i", $utilizador_id);
        mysqli_stmt_execute($viagem_stmt);

        $utilizador_sql = "DELETE FROM utilizador WHERE id=?";
        $utilizador_stmt = mysqli_prepare($this->link, $utilizador_sql);
        mysqli_stmt_bind_param($utilizador_stmt, "i", $utilizador_id);
        mysqli_stmt_execute($utilizador_stmt);
    }

    public function getUtilizadorID($email) {
        $sql = "SELECT id FROM utilizador WHERE email = ?";
        $stmt = mysqli_prepare($this->link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return $id;
    }

    public function editarUtilizador($nome, $email) {

        $utilizador_id = $_SESSION['userID'];

        $sql = "UPDATE utilizador 
            SET nome = ?, 
                email = ?
            WHERE id = $utilizador_id";

        if ($stmt = mysqli_prepare($this->link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_nome, $param_email);

            // Set parameters
            $param_nome = $nome;
            $param_email = $email;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }

        // Display the error message if there was an issue with the execution
        if (isset($error_message)) {
            echo $error_message;
        }
    }

    public function registerCarro($autonomia, $bateria, $consumoMedio, $matricula, $modelo, $velocidadeMedia) {

        $utilizador_id = $_SESSION['userID'];
        // Prepare an insert statement
        $sql = "INSERT INTO carro (autonomia, bateria, consumoMedio, matricula, modelo, velocidadeMedia, utilizador_id) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($this->link, $sql)) {
            // Bind variables to the prepared statement as parameters
            $param_utilizador_id = $utilizador_id;
            mysqli_stmt_bind_param($stmt, "ssssssi", $param_autonomia, $param_bateria, $param_consumoMedio, $param_matricula, $param_modelo, $param_velocidadeMedia, $param_utilizador_id);

            // Set parameters
            $param_autonomia = $autonomia;
            $param_bateria = $bateria;
            $param_consumoMedio = $consumoMedio;
            $param_matricula = $matricula;
            $param_modelo = $modelo;
            $param_velocidadeMedia = $velocidadeMedia;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }

        // Display the error message if there was an issue with the execution
        if (isset($error_message)) {
            echo $error_message;
        }
    }

    public function getIDCarro() {
        $utilizador_id = $_SESSION['userID'];
        $sql = "SELECT id FROM carro WHERE utilizador_id = $utilizador_id";
        $result = mysqli_query($this->link, $sql);
        $ids = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ids[] = $row["id"];
            }
        }


        $selectOptions = '';
        foreach ($ids as $id) {
            $selectOptions .= "<option value='$id'>$id</option>";
        }

        return $selectOptions;
    }

    public function getCarro() {
        $utilizador_id = $_SESSION['userID'];
        $sql = "SELECT * FROM carro WHERE utilizador_id = $utilizador_id";
        $result = mysqli_query($this->link, $sql);

        $carros = array(); // Initialize an empty array to store the car records

        while ($row = mysqli_fetch_assoc($result)) {
            $carros[] = $row; // Append each row to the carros array
        }

        return $carros;
    }

    public function getCarroByID($id) {
        $sql = "SELECT * FROM carro WHERE id = $id";
        $result = mysqli_query($this->link, $sql);

        $carro = mysqli_fetch_assoc($result); // Initialize an empty array to store the car records

        return $carro;
    }

    public function getAllMatriculasCarros() {
        $utilizador_id = $_SESSION['userID'];

        $sql = "SELECT matricula FROM carro WHERE utilizador_id = $utilizador_id";
        $result = mysqli_query($this->link, $sql);

        $options = "";

        while ($row = mysqli_fetch_assoc($result)) {
            $matricula = $row['matricula'];
            $options .= "<option value=\"$matricula\">$matricula</option>";
        }

        return $options;
    }

    public function editarCarro($carro_id, $modelo, $matricula, $consumoMedio, $bateria, $autonomia, $velocidadeMedia) {

        $sql = "UPDATE carro 
            SET modelo = ?, 
                matricula = ?, 
                consumoMedio = ?, 
                bateria = ?, 
                autonomia = ?, 
                velocidadeMedia = ? 
            WHERE id = $carro_id";

        if ($stmt = mysqli_prepare($this->link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssiiii", $param_modelo, $param_matricula, $param_consumoMedio, $param_bateria, $param_autonomia, $param_velocidadeMedia);

            // Set parameters
            $param_modelo = $modelo;
            $param_matricula = $matricula;
            $param_consumoMedio = $consumoMedio;
            $param_bateria = $bateria;
            $param_autonomia = $autonomia;
            $param_velocidadeMedia = $velocidadeMedia;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
        } else {
            $error_message = "Oops! Something went wrong. Please try again later.";
        }

        // Display the error message if there was an issue with the execution
        if (isset($error_message)) {
            echo $error_message;
        }
    }

    public function deleteCarro($id) {
        $sql = "DELETE FROM carro WHERE id=?";
        $stmt = mysqli_prepare($this->link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    public function registarViagens($pontoPartida, $pontoChegada, $matriculaCarro, $tipoViagem) {
        $utilizador_id = $_SESSION['userID'];

        $sql = "SELECT id FROM carro WHERE matricula = '$matriculaCarro'";
        $result = mysqli_query($this->link, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $param_carro_id = $row['id'];

            $sql = "INSERT INTO viagem (pontoPartida, pontoChegada, tipoViagem, utilizador_id, carro_id) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($this->link, $sql)) {
                $param_utilizador_id = $utilizador_id;
                mysqli_stmt_bind_param($stmt, "sssii", $param_pontoPartida, $param_pontoChegada, $param_tipoViagem, $param_utilizador_id, $param_carro_id);

                // Set parameters
                $param_pontoPartida = $pontoPartida;
                $param_pontoChegada = $pontoChegada;
                $param_tipoViagem = $tipoViagem;

                if (mysqli_stmt_execute($stmt)) {
                    
                } else {
                    $error_message = "Oops! Something went wrong. Please try again later.";
                }
            } else {
                $error_message = "Oops! Something went wrong. Please try again later.";
            }
        } else {
            $error_message = "Error retrieving car ID from the database.";
        }
    }

    public function getViagens() {
        $utilizador_id = $_SESSION['userID'];

        $sql = "SELECT * FROM viagem WHERE utilizador_id = $utilizador_id";
        $result = mysqli_query($this->link, $sql);

        $viagens = array(); // Initialize an empty array to store the car records

        while ($row = mysqli_fetch_assoc($result)) {
            $viagens[] = $row; // Append each row to the carros array
        }

        return $viagens;
    }

    public function getIDViagens() {
        $utilizador_id = $_SESSION['userID'];

        $sql = "SELECT id FROM viagem WHERE utilizador_id = $utilizador_id";
        $result = mysqli_query($this->link, $sql);
        $ids = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $ids[] = $row["id"];
            }
        }

        $selectOptions = '';
        foreach ($ids as $id) {
            $selectOptions .= "<option value='$id'>$id</option>";
        }

        return $selectOptions;
    }

    public function getViagem($viagem_id) {

        $sql = "SELECT * FROM viagem WHERE id = $viagem_id";
        $result = mysqli_query($this->link, $sql);

        if ($result->num_rows > 0) {
            $viagem = $result->fetch_assoc();
            return $viagem;
        }

        return null; // Return null if no viagem found with the specified ID
    }

    public function calcularRota($viagem) {
        $csvFile = fopen("../excel/LSIS1-Lista_Carregadores_Tesla_Europa.csv", "r");

        $partida = $viagem['pontoPartida'];
        $chegada = $viagem['pontoChegada'];

        $carro_id = $viagem['carro_id'];
        $carro = $this->getCarroByID($carro_id);

        $intermedioStart = explode(',', $partida);
        $latitudeStart = floatval(trim($intermedioStart[0])); // Trim whitespace and convert to float
        $longitudeStart = floatval(trim($intermedioStart[1])); // Trim whitespace and convert to float
        $intermedioFinish = explode(',', $chegada);
        $latitudeFinish = floatval(trim($intermedioFinish[0])); // Trim whitespace and convert to float
        $longitudeFinish = floatval(trim($intermedioFinish[1])); // Trim whitespace and convert to float

        $coordinatesStart = array($longitudeStart, $latitudeStart);
        $coordinatesFinish = array($longitudeFinish, $latitudeFinish);

        $totalDistance = $this->calculateDistance($coordinatesStart[1], $coordinatesStart[0], $coordinatesFinish[1], $coordinatesFinish[0]);

        $velocidadeMedia = $carro['velocidadeMedia'];
        $autonomia = $carro['autonomia']; // Autonomia
        $consumoMedio = $carro['consumoMedio'];

        $tipoDeViagem = "distancia";

        $velocidadeCarregamento = 10;

        if ($csvFile) {
            $valuesArray = [];

            $firstRowSkipped = false;
            $counter = 0;

            $valuesArray[] = $coordinatesStart;

            while (($data = fgetcsv($csvFile, 0, ';')) !== false) {
                if (!$firstRowSkipped) {
                    $firstRowSkipped = true;
                    continue; // Skip the first row
                }

                $coordinates = explode(',', $data[8]); // Split the value by comma
                $latitude = floatval(trim($coordinates[0])); // Trim whitespace and convert to float
                $longitude = floatval(trim($coordinates[1])); // Trim whitespace and convert to float
                $distanceBetweenStartAndCharger = $this->calculateDistance($coordinatesStart[1], $coordinatesStart[0], $latitude, $longitude);
                if ($distanceBetweenStartAndCharger <= $totalDistance) {
                    $coordinate = [$longitude, $latitude]; // Create the coordinate pair
                    $valuesArray[] = $coordinate; // Save the coordinate in the array
                }

                $counter++;
                if ($counter >= 1110) {
                    break;
                }
            }

            $valuesArray[] = $coordinatesFinish;

            fclose($csvFile);
        }

        // Generate the CSV content
        $csvFilePath = "../excel/matrix_caminho_minimo.csv";
        $csvContent = "";
        for ($i = 0; $i < count($valuesArray); $i++) {
            for ($j = 0; $j < count($valuesArray); $j++) {
                $destination = $valuesArray[$j];
                $distance = $this->calculateDistance($valuesArray[$i][1], $valuesArray[$i][0], $destination[1], $destination[0]);
                if ($distance >= $autonomia) {
                    $distance = 0;
                }

                if ($tipoDeViagem == "tempo") {
                    $tempo = ($distance / $velocidadeMedia) + ($distance * $consumoMedio / $velocidadeCarregamento);
                    $csvContent .= $tempo . ",";
                } else if ($tipoDeViagem == "distancia") {
                    $csvContent .= $distance . ",";
                }
            }
            $csvContent = rtrim($csvContent, ","); // Remove trailing comma from each row
            $csvContent .= "\n";
        }

        // Save the CSV content to the file
        $fileSaved = file_put_contents($csvFilePath, $csvContent, LOCK_EX);
        if ($fileSaved !== false) {
            echo "CSV file overwritten. <br>";
        } else {
            echo "Failed to overwrite the CSV file. <br>";
        }

        shell_exec("java -jar C:\\xampp\\htdocs\\LSIS1\\model\\ortoolsSolveInputOutput-1.0-SNAPSHOT-jar-with-dependencies.jar");
        echo "Java concluido <br>";

        $csvResultados = fopen("../excel/output.csv", "r");

        $arrayResultados = [];

        if ($csvResultados !== false) {

            $csvLinha1 = fgetcsv($csvResultados, 0, ";");
            $columnCount = count(array_filter($csvLinha1)); // Count non-empty columns in the current row

            $arrayResultados[] = $csvLinha1[0];

            $valorIndex = 1;
            while ($valorIndex !== $columnCount + 1) {
                $index = (int) $csvLinha1[$valorIndex];
                $gps = $valuesArray[$index];
                $lat = $gps[1];
                $long = $gps[0];
                $arrayResultados[] = $lat . ',' . $long;  
                $valorIndex++;
                $valorIndex;
            }
        } else {
            echo "Failed to read the CSV file.";
        }

        return $arrayResultados;
    }

    public function deleteViagens($id) {

        $sql = "DELETE FROM viagem WHERE id=?";
        $stmt = mysqli_prepare($this->link, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    // Haversine para calcular distancia de duas coordenadas
    public function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371; // Raio da terra em km

        $dLat = $this->toRadians($lat2 - $lat1);
        $dLon = $this->toRadians($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
                cos($this->toRadians($lat1)) * cos($this->toRadians($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $R * $c; // Distancia em km
        return $distance;
    }

    // Graus para radianos
    public function toRadians($degrees) {
        return $degrees * (pi() / 180);
    }

}
