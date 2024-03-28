<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client et voiture</title>
    <link rel="stylesheet" href="Affichage-voiture.css">
</head>
<body>
    <h1>AFFICHAGE DE LA LISTE DES VOITURES</h1>
    <h2>Ajouter</h2>
    <a href="Ajouter-voiture.php"><img src="img/client4.png" class="image4"></a>
    <a href="../Acceuil.php"><img src="img/icone3.png" class="image3"></a>
    <table>
        <thead>
            <tr id="ligne">
                <th scope="col">Idvoit</th> 
                <th scope="col">Design</th>
                <th scope="col">Type</th>
                <th scope="col">Nombre de place</th>
                <th scope="col">Frais</th>
                <th scope="col">Modifier</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
    <?php
        include "connexion.php";
        $sql3 = "SELECT * FROM Voiture";
        $resultat = mysqli_query($conn, $sql3);
        
        if ($resultat) {  
            while ($row = mysqli_fetch_assoc($resultat)) {                 
                $idvoit=$row['Idvoit'];
                $design=$row['Design'];
                $Type=$row['Type'];
                $nbr_place=$row['nbr_place'];
                $Frais=$row['Frais'];
                    echo "<tr>
                          <th scope='col'>" . $idvoit . "</th>
                          <td>" . $design . "</td>
                          <td>" . $Type . "</td>
                          <td>" . $nbr_place. "</td>
                          <td>" . $Frais . "</td>
                          <td>
                             <a href=\"Modifier-voiture.php? Modifier-voitureIdvoit=".$idvoit."\">
                             <img src=\"img/modifier1.png\" width=\"30px\" heigth=\"50px\"></a>
                          </td>
                          <td>
                          <a href=\"Supprimer-voiture.php? Supprimer-voitureIdvoit=".$idvoit."\">
                          <img src=\"img/Supprimer.jpg\" width=\"30px\" heigth=\"50px\"></a>
                       </td>
                          </tr>";
                }
            } else {
                echo "0 results";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>
</html>
