<?php
$ch = curl_init();
// Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

require_once 'model/UserModel.php';
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
        <link rel="stylesheet" href="css/cssPlanear.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
              crossorigin=""/>

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>




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


        <div id="top-left">
            <br><br><br>
            <form action="controller/controllerPlanear.php" method="post">
                <input type='hidden' name='form_type' value='form1'>
                <h2>Planear viagem</h2>
                <p>Coordenadas de partida: <input type="text" id="partida-input" name="pontoPartida" placeholder="Digite as coordenadas de partida"></p>
                <p>Coordenadas de chegada: <input type="text" id="chegada-input" name="pontoChegada" placeholder="Digite as coordenadas de chegada"></p>


                <select name="matriculaParaViagem" required="required">
                    <option value="">Selecione o seu veículo</option>
                    <?php
                    $userModel = new UserModel();
                    $matriculas = $userModel->getAllMatriculasCarros();
                    echo $matriculas;
                    ?>
                </select>


                <select name="tipoViagem" required="required">
                    <option value="">Selecione o tipo de viagem</option>
                    <option value="economica">Economica</option>
                    <option value="rapida">Rápida</option>
                </select>
                <button type="submit" value="Submeter">Enviar</button>
            </form>

        </div>


        <div id="right">
            <br><br><br>
            <?php
            $userModel = new UserModel();
            $result = $userModel->getViagens();

            if ($result) {
                ?>
                <h2>Informações das viagens</h2>
                <table>
                    <tr>
                        <th>Ponto de Partida</th>
                        <th>Ponto de Chegada</th>
                        <th>Tipo de Viagem</th>
                        <th>Opções</th>
                    </tr>

                    <?php foreach ($result as $row) { ?>
                        <tr>
                            <td><?php echo $row['pontoPartida']; ?></td>
                            <td><?php echo $row['pontoChegada']; ?></td>
                            <td><?php echo $row['tipoViagem']; ?></td>
                            <td>
                                <form action="controller/controllerPlanear.php" method="POST">
                                    <input type="hidden" name="formVerViagem" value="<?php echo $row['id']; ?>">
                                    <button class="btn-alterar" type="submit">Ver rota</button>
                                </form>
                                <form action="controller/controllerPlanear.php" method="POST">
                                    <input type="hidden" name="formEliminarViagem" value="<?php echo $row['id']; ?>">
                                    <button class="btn-eliminar" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>Erro ao obter as viagens.</p>
            <?php } ?>


            <?php
            $resultado = $_SESSION['resultados'];
            $valorObjetivo = array_shift($resultado);
// Atribuir o primeiro elemento do caminho mínimo ao $start
            $start = $resultado[0];
// Atribuir o último elemento do caminho mínimo ao $end
            $end = end($resultado);
// Extrair a latitude e longitude de $start
            $startCoordinates = explode(',', $start);
            $startLatitude = $startCoordinates[0];
            $startLongitude = $startCoordinates[1];

// Extrair a latitude e longitude de $end
            $endCoordinates = explode(',', $end);
            $endLatitude = $endCoordinates[0];
            $endLongitude = $endCoordinates[1];

// Reformatar a ordem para longitude, latitude
            $vetor = array();
            $vetor[0] = "[" . $startLongitude . ',' . $startLatitude . "]";

            for ($i = 1; $i < count($resultado) - 1; $i++) {
                $coordinates = explode(',', $resultado[$i]);
                $latitude = $coordinates[0];
                $longitude = $coordinates[1];
                $vetor[] = "[" . $longitude . ',' . $latitude . "]";
            }

            $vetor[$i] = "[" . $endLongitude . ',' . $endLatitude . "]";

            curl_setopt($ch, CURLOPT_URL, "https://api.openrouteservice.org/v2/directions/driving-hgv/geojson");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);

            curl_setopt($ch, CURLOPT_POST, TRUE);

            $t = "";
            foreach ($vetor as $x) {
                $t = $t . $x . ",";
            }
            $t = substr($t, 0, -1);

            curl_setopt($ch, CURLOPT_POSTFIELDS, '{"coordinates":[' . $t . ']}');

            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Accept: application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8",
                "Authorization:5b3ce3597851110001cf62488cc6db05885749dabd94695e0ee9da65", //colocar a KEY
                "Content-Type: application/json; charset=utf-8"
            ));

            $response = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($response, true);
// Extrair informações da resposta
            $distance = $data['features'][0]['properties']['summary']['distance'];
            $duration = $data['features'][0]['properties']['summary']['duration'];
            $instructions = $data['features'][0]['properties']['segments'][0]['steps'];
// Converter distância de metros para quilômetros
            $distanceInKm = number_format($distance / 1000, 2);
// Converter tempo de segundos para horas
            $durationInHours = number_format($duration / 3600, 2);
            ?>

        </div>
        <br><br>

        <div id="bottom-left">
    <h2>Mapa da viagem</h2> 
    <div class="scrollable-div">
        <div id="map"></div>
        <div id="panel">
            <div class="panel-content">
                <?php foreach ($instructions as $step): ?>
                    <li><?php echo $step['instruction']; ?></li>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
                <script>
                    //costumizar os marcadores com cores diferentes
                    var greenIcon = new L.Icon({
                        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                        iconSize: [25, 41],
                        iconAnchor: [12, 41],
                        popupAnchor: [1, -34],
                        shadowSize: [41, 41]
                    });

                    //https://wiki.openstreetmap.org/wiki/Routing#End_users:_routing_software
                    //https://openrouteservice.org/dev/#/api-docs/introduction

                    //As coordenadas na API LeafLetJS são do tipo [lat,long] 
                    var start = <?php echo $vetor[0]; ?>;


                    var map = L.map('map').setView([start[1], start[0]], 6);

                    mapLink = "<a href='http://openstreetmap.org'>OpenStreetMap</a>";
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: 'Leaflet &copy; ' + mapLink + ', contribution',
                        maxZoom: 18
                    }).addTo(map);
                    var data = <?php echo $response; ?>;

                    L.geoJSON(data).addTo(map);
                    console.log(data);

<?php
$i = 1;
foreach ($resultado as $x) {
    echo "var marker" . $i . " = L.marker([" . $x . "]).addTo(map);";
    echo "marker" . $i . ".bindPopup('Início" . $i . "');";
    $i++;
}
?>



                </script>
            </div>
        </div>
        <br><br><br><br>

    </body>
</html>