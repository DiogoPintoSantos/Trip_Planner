<?php
//Initialize the session
if (!isset($_SESSION)) {
    session_start();
}

?>

<html>
<head>
    <title>Visualização da tabela excel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/tabelaExcel.css"/>
    <link rel="shortcut icon" href="images/1am.png" type="image/x-icon">
</head>


    <head>
        <title>Table Filtering</title>
    </head>
    <body>
<nav class="barra">
            <a class="barrabutton" href=Site.php>HOME</a> 
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
        <br><br><br><br>
    <!-- Form para filtrar por cidade -->
    <form>
        <label for="filterSelect1">Filter by City:</label>
        <select name="filter" id="filterSelect1" onchange="filterTable()">
            <option value="">All</option>
            <?php
            $csvFile = fopen("excel/LSIS1-Lista_Carregadores_Tesla_Europa.csv", "r");
            if ($csvFile) {

                $header = fgetcsv($csvFile, 0, ';');  // Remove header
                $desiredColumn1 = 2;                  // Column index for cities
                $options = [];

                while (($data = fgetcsv($csvFile, 0, ';')) !== false) {
                    $value = $data[$desiredColumn1];
                    if (!in_array($value, $options)) {
                        $options[] = $value;
                        echo "<option value='$value'>$value</option>";
                    }
                }

                fclose($csvFile);
            }
            ?>
        </select>
    </form>

    <!-- Form para filtrar por país -->
    <form>
        <label for="filterSelect2">Filter by Country:</label>
        <select name="filter" id="filterSelect2" onchange="filterTable()">
            <option value="">All</option>
            <?php
            $csvFile = fopen("excel/LSIS1-Lista_Carregadores_Tesla_Europa.csv", "r");
            if ($csvFile) {

                $header = fgetcsv($csvFile, 0, ';');  // Remove header
                $desiredColumn2 = 5;                  // Column index for countries
                $options = [];

                while (($data = fgetcsv($csvFile, 0, ';')) !== false) {
                    $value = $data[$desiredColumn2];
                    if (!in_array($value, $options)) {
                        $options[] = $value;
                        echo "<option value='$value'>$value</option>";
                    }
                }

                fclose($csvFile);
            }
            ?>
        </select>
    </form>

    <br>

    <?php
    $csvFile = fopen("excel/LSIS1-Lista_Carregadores_Tesla_Europa.csv", "r");

    if ($csvFile) {
        $data = fgetcsv($csvFile, 0, ';');  
        echo "<table id='tabelaCarregadores'><thead><tr>";
        foreach ($data as $value) {
            echo "<th>$value</th>";
        }
        echo "</tr></thead>";

        echo "<tbody>";

        while (($data = fgetcsv($csvFile, 0, ';')) !== false) {
            echo "<tr>";
            foreach ($data as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        fclose($csvFile);
    }
    ?>

    <script>
        function filterTable() {
            var selectColumn1 = document.getElementById("filterSelect1");
            var selectColumn2 = document.getElementById("filterSelect2");
            var selectedValueColumn1 = selectColumn1.value.toLowerCase();
            var selectedValueColumn2 = selectColumn2.value.toLowerCase();
            var table = document.getElementById("tabelaCarregadores");
            var rows = table.getElementsByTagName("tr");

            for (var i = 1; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName("td");
                var cellValueColumn1 = cells[2].textContent.toLowerCase(); // Assuming column 1 is the third column
                var cellValueColumn2 = cells[5].textContent.toLowerCase(); // Assuming column 2 is the sixth column

                var showRow = (selectedValueColumn1 === "" || cellValueColumn1 === selectedValueColumn1) &&
                    (selectedValueColumn2 === "" || cellValueColumn2 === selectedValueColumn2);

                rows[i].style.display = showRow ? "" : "none";
            }
        }
    </script>
    </body>
</html>





