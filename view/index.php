<?php
require_once 'planear.php';
$csvFile = fopen("excel/LSIS1-Lista_Carregadores_Tesla_Europa.csv", "r");

$partida = $_POST['partida'];
$chegada = $_POST['chegada'];
$coordinatesStart = array($partida[1], $partida[0]);  // [longitude, latitude]
$coordinatesFinish = array($chegada[1], $chegada[0]); 
$totalDistance = calculateDistance($coordinatesStart[1], $coordinatesStart[0], $coordinatesFinish[1], $coordinatesFinish[0]);

$velocidadeMedia = 45;
$autonomia = 150; // Autonomia
$consumoMedio = 20;
$tipoDeViagem = "tempo";

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
        $distanceBetweenStartAndCharger = calculateDistance($coordinatesStart[1], $coordinatesStart[0], $latitude, $longitude);
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

// Haversine para calcular distancia de duas coordenadas
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Raio da terra em km

    $dLat = toRadians($lat2 - $lat1);
    $dLon = toRadians($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(toRadians($lat1)) * cos(toRadians($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    $distance = $R * $c; // Distancia em km
    return $distance;
}

// Graus para radianos
function toRadians($degrees) {
    return $degrees * (pi() / 180);
}

// Generate the CSV content
$csvFilePath = "excel/matrix_caminho_minimo.csv";
$csvContent = "";
for ($i = 0; $i < count($valuesArray); $i++) {
    for ($j = 0; $j < count($valuesArray); $j++) {
        $destination = $valuesArray[$j];
        $distance = calculateDistance($valuesArray[$i][1], $valuesArray[$i][0], $destination[1], $destination[0]);
        if ($distance >= $autonomia) {
            $distance = 0;
        }

        if ($tipoDeViagem == "tempo") {
            $tempo = ($distance / $velocidadeMedia) + ($distance*$consumoMedio/$velocidadeCarregamento);
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

shell_exec("java -jar .\ortoolsSolveInputOutput-1.0-SNAPSHOT-jar-with-dependencies.jar");
echo "Java concluido <br>";

$csvResultados = fopen("excel/output.csv", "r");

if ($csvResultados !== false) {

    $csvLinha1 = fgetcsv($csvResultados, 0, ";");
    $columnCount = count(array_filter($csvLinha1)); // Count non-empty columns in the current row

    $valorObjetivo = $csvLinha1[0];

    echo $valorObjetivo;
    echo "<br>";

    $valorIndex = 1;
    while ($valorIndex !== $columnCount+1) {
        $index = (int) $csvLinha1[$valorIndex];
        $gps = $valuesArray[$index];
        $lat = $gps[1];
        $long = $gps[0];
        $coordinates = $lat . ',' . $long;
        echo $coordinates . "<br>";
        $valorIndex++;
        $valorIndex;
    }
} else {
    echo "Failed to read the CSV file.";
}
?>

