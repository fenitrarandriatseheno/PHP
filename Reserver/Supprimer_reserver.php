<?php
include 'connexion.php';

if (isset($_GET['Supprimer_reserverIdreserv']) && isset($_GET['Supprimer_reserverdate_reserv'])) {
    $Idreserv = $_GET['Supprimer_reserverIdreserv'];
    $date_reserv = $_GET['Supprimer_reserverdate_reserv'];

    $sqlSupp = "DELETE FROM reserver WHERE Idreserv='$Idreserv' AND date_reserv='$date_reserv'";
    $res = mysqli_query($conn, $sqlSupp);

    if ($res) {
        header('location: Affichage_reserv.php');
        //echo"suppresion";
    } else {
        echo "Erreur de suppression : " . mysqli_error($conn);
    }
}
?>
