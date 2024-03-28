<?php
include 'connexion.php';

if (isset($_GET['Supprimer-placeplace'])) {
    $place = $_GET['Supprimer-placeplace'];

    $sqlSupp = "DELETE FROM Place WHERE Place=$place";
    $res = mysqli_query($conn, $sqlSupp);

    if ($res) {
        header('location: Listage-place.php');
        //echo"suppresion";
    } else {
        echo "Erreur de suppression : " . mysqli_error($conn);
    }
}
?>