<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client et voiture</title>
    <link rel="stylesheet" href="Affichage_reserver.css">
</head>
<body>
    <h1>Affichage pour la liste des reservations </h1>
    <h2>Ajouter</h2>
    <form method="GET">
    <div>
        <label class="recherche1">Recherche : </label>
        <select name="payement" id="recherche1">
            <option value="sans_avance">Sans avance</option>
            <option value="avec avance">Avec avance</option>
            <option value="tout payer">Tout payer</option>
        </select>
    </div>
</form>
    <a href="essaiplace.php"><img src="images/client4.png" class="image4"></a>
    <a href="../Acceuil.php"><img src="images/icone3.png" class="image3"></a>
    <table id="clientTable">
        <thead>
            <tr id="ligne">
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
        include "connexion.php";
        $sql3 = "SELECT Idreserv,reserver.Idvoit,reserver.IdClient,reserver.place,date_reserv,date_voyage,payement,Montant_avance,Frais  
                 FROM reserver,Voiture
                 WHERE Voiture.Idvoit=reserver.Idvoit
                 ORDER BY Idvoit ASC";
        $resultat = mysqli_query($conn, $sql3);
        
        if ($resultat) {  
            while ($row = mysqli_fetch_assoc($resultat)) {                 
                $Idreserver=$row['Idreserv'];
                $idvoit=$row['Idvoit'];
                $idClient=$row['IdClient'];
                $place=$row['place'];
                $date_reserv=$row['date_reserv'];
                $date_voyage=$row['date_voyage'];
                $payement=$row['payement'];
                $Montant=$row['Montant_avance'];
                $Frais=$row['Frais'];  
                if ($Frais<$Montant) {
                    $Reste=0;
                    
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
                        <a href=\"Modifier-reserver.php? Modifier-reservIdreserv=" . $Idreserver. "&&Modifier_reservdate_reserv=" . $date_reserv ."\">
                        <img src=\"images/modifier1.png\" width=\"30px\" heigth=\"50px\"></a>
                    </td>
                    <td>
                        <a href=\"Supprimer_reserver.php?Supprimer_reserverIdreserv=" . $Idreserver . "&&Supprimer_reserverdate_reserv=" . $date_reserv . "\">
                        <img src=\"images/Supprimer.jpg\" width=\"30px\" height=\"30px\"></a>
                    </td>
                    </tr>";
                } 
                else {             
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
                                <a href=\"Modifier-reserver.php? Modifier-reservIdreserv=" . $Idreserver. "&&Modifier_reservdate_reserv=" . $date_reserv ."\">
                                <img src=\"images/modifier1.png\" width=\"30px\" heigth=\"50px\"></a>
                            </td>
                            <td>
                                <a href=\"Supprimer_reserver.php?Supprimer_reserverIdreserv=" . $Idreserver . "
                                &&Supprimer_reserverdate_reserv=" . $date_reserv . "&&Supprimer_reserverIdvoit=".$idvoit."\">
                                <img src=\"images/Supprimer.jpg\" width=\"30px\" height=\"30px\"></a>
                            </td>
                            </tr>";
                }
            }
            } else {
                echo "0 results";
            }
    ?>
        </tbody>
    </table>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var searchInput = document.getElementById('recherche1');

        searchInput.addEventListener('change', function () {
            var selectedValue = searchInput.value;

            // Perform an AJAX request to update the table content
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('clientTable').innerHTML = xhr.responseText;
                }
            };

            xhr.open('GET', 'recherche-dynamique.php?payement=' + selectedValue, true);
            xhr.send();
        });
    });
</script>

</body>
</html>
