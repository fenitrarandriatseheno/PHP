<?php
   include 'connexion.php';
   if (isset($_GET['Supprimer-voitureIdvoit'])) {
       $Idvoit=$_GET['Supprimer-voitureIdvoit'];

       $sqlSuppReserver = "DELETE FROM reserver WHERE Idvoit='$Idvoit'";
       $resReserver = mysqli_query($conn, $sqlSuppReserver);

       $sql= "DELETE FROM Voiture WHERE Idvoit='$Idvoit'";
       $res=mysqli_query($conn,$sql);

       if ($res) {
          header('location:Affichage-voiture.php');
       }else {
          echo "non supprimer" . mysqli_error($conn);
       }
   }
   mysqli_close($conn);
?>