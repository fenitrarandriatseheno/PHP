<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>recherche</title>
    <link rel="stylesheet" href="Affichage_reserv.css">
</head>
<body>
<table id="clientTable">
        <thead>
            <tr>
                <th scope="col">Idreserver</th> 
                <th scope="col">Idvoit</th>
                <th scope="col">IdClient</th>
                <th scope="col">place</th>
                <th scope="col">date reservation</th>
                <th scope="col">Date voyage</th>
                <th scope="col">Payement</th>
                <th scope="col">Montant avance</th>
                <th scope="col">Reste a payer</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Modify your existing code to include the payment condition
            include "connexion.php";

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                $condition = "";
                if (isset($_GET['payement']) && !empty($_GET['payement'])) {
                    $selectedPayment = htmlspecialchars($_GET['payement']);
                    $condition = "AND payement LIKE '%" . $selectedPayment ."%'";
                }

            $sql = "SELECT Idreserv,reserver.Idvoit,reserver.IdClient,reserver.place,date_reserv,date_voyage,payement,Montant_avance,Frais /*,count(Place) as Nombre_reservation*/
                    FROM reserver,Voiture
                    WHERE Voiture.Idvoit=reserver.Idvoit 
                    $condition";
            $resultat = mysqli_query($conn, $sql);

            if ($resultat) {
                while ($row = mysqli_fetch_assoc($resultat)) {
                    $Idreserver = $row['Idreserv'];
                    $idvoit = $row['Idvoit'];
                    $idClient = $row['IdClient'];
                    $place = $row['place'];
                    $date_reserv = $row['date_reserv'];
                    $date_voyage = $row['date_voyage'];
                    $payement = $row['payement'];
                    $Montant = $row['Montant_avance'];               
                    $Frais=$row['Frais'];                
                    $Reste= $Frais - $Montant; 

                    echo "<tr>
                          <th scope='col'>" .  $Idreserver  . "</th>
                          <td>" . $idvoit . "</td>
                          <td>" . $idClient . "</td>
                          <td>" . $place . "</td>
                          <td>" . $date_reserv. "</td>
                          <td>" . $date_voyage . "</td>
                          <td>" . $payement. "</td>
                          <td>" . $Montant . "</td>
                          <td>" . $Reste. "</td>
                          <td>
                             <a href=\"Modifier-reserver.php? Modifier-reservIdreserv=".$Idreserver."\">
                             <img src=\"images/modifier1.png\" width=\"30px\" heigth=\"50px\"></a>
                          </td>
                          <td>
                             <a href=\"Supprimer-reserver.php? Supprimer-reserverIdreserv=".$Idreserver."\">
                             <img src=\"images/Supprimer.jpg\" width=\"30px\" heigth=\"50px\"></a>
                          </td>
                          </tr>";
                }
            } else {
                echo "0 results";
            }
        }
    ?>
        </tbody>
    </table>
</body>
</html>