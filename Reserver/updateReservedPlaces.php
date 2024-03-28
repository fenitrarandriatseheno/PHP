<?php
include "connexion.php";

if (isset($_GET['Idvoit'])) {
    $selectedIdvoit = mysqli_real_escape_string($conn, htmlspecialchars($_GET['Idvoit']));
    $sqlReservedPlaces = "SELECT numero_place FROM place WHERE Idvoit = '$selectedIdvoit' AND occupation = 'OUI'";
    $resultReservedPlaces = mysqli_query($conn, $sqlReservedPlaces);

    $reservedPlaces = array();
    while ($rowReservedPlace = mysqli_fetch_assoc($resultReservedPlaces)) {
        $reservedPlaces[] = $rowReservedPlace['numero_place'];
    }

    echo json_encode($reservedPlaces);
} else {
    echo "Paramètre 'Idvoit' non fourni.";
}

mysqli_close($conn);
?>