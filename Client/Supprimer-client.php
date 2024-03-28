<?php
    include 'connexion.php';
    if (isset($_GET['Supprimer-ClientIdClient'])) {
        $IdClient = $_GET['Supprimer-ClientIdClient'];

        // Suppression des réservations associées au client
        $sqlSuppReserver = "DELETE FROM reserver WHERE IdClient=$IdClient";
        $resReserver = mysqli_query($conn, $sqlSuppReserver);

        // Suppression du client lui-même
        $sqlSuppClient = "DELETE FROM Client WHERE IdClient=$IdClient";
        $resClient = mysqli_query($conn, $sqlSuppClient);

        if ($resClient) {
            header('location:Affichage-Client.php');
        } else {
            echo "Erreur de suppression";
            mysqli_query($conn);
        }
    }
?>
