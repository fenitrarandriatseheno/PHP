<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client et voiture</title>
    <link rel="stylesheet" href="Affichage_reserver.css">
</head>
<body>
    <h1>Affichage des reservations</h1><br>
    <table>
        <thead>
            <tr>
                <th scope="col">Idreserver</th> 
                <th scope="col">Nom</th>
                <th scope="col">Telephone</th>
                <th scope="col">Design</th>
                <th scope="col">Type</th>
                <th scope="col">place</th>
                <th scope="col">date reservation</th>
                <th scope="col">Date voyage</th>
                <th scope="col">Payement</th>
                <th scope="col">Montant Avance</th>
                <th scope="col">Reste à payer</th>
                <th scope="col">Recu client</th>
            </tr>
        </thead>
        <tbody>
    <?php
        include "connexion.php";
        $sql3 = "SELECT Idreserv,Nom, Numtel,Design,Type, reserver.place, date_reserv, date_voyage, payement, Montant_avance , Frais /*,SUM(Montant_avance) as recette_total*/
                 FROM reserver,Client,Voiture where Client.IdClient=reserver.IdClient
                 AND Voiture.Idvoit=reserver.Idvoit 
                 ORDER BY Idreserv  ASC";
                 /*, Nom, Numtel, Design,Type,
                 ,Client,Voiture,Place where Client.IdClient=reserver.IdClient 
                 AND Voiture.Idvoit=reserver.Idvoit AND Place.Idvoit=reserver.Idvoit
                 AND Place.place=reserver.place
                 ORDER BY Idreserv  ASC";*/
        $resultat = mysqli_query($conn, $sql3);
        
        if ($resultat) {  
            while ($row = mysqli_fetch_assoc($resultat)) {                 
                $Idreserver=$row['Idreserv'];
                $Nomclient=$row['Nom'];
                $telephone=$row['Numtel'];
                $Design=$row['Design'];
                $Type=$row['Type'];
                $place=$row['place'];
                $date_reserv=$row['date_reserv'];
                $date_voyage=$row['date_voyage'];
                $payement=$row['payement'];
                $Montant=$row['Montant_avance'];
                //$Somme=$row['recette_total'];
                $Frais=$row['Frais'];
                $Reste= $Frais - $Montant;
                    echo "<tr>
                          <th scope='col'>" .  $Idreserver  . "</th>
                          <td>" . $Nomclient . "</td>
                          <td>" . $telephone. "</td>
                          <td>" . $Design . "</td>
                          <td>" . $Type. "</td>
                          <td>" . $place . "</td>
                          <td>" . $date_reserv. "</td>
                          <td>" . $date_voyage . "</td>
                          <td>" . $payement. "</td>
                          <td>" . $Montant . "</td>
                          <td>" . $Reste . "</td>
                         
                          <td>
                          <a href=\"Recu_Client.php? Recu_ClientIdreserv=".$Idreserver."\">
                          <img src=\"images/recu.jpg\" width=\"30px\" heigth=\"50px\" border-radius=\"10px\"></a>
                          </td>
                          </tr>";
                          
                }
                       
            } else {
                echo "0 results";
            }
            //echo " <tr> <td colspan='4'> $Somme </td>   </tr>";

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>
