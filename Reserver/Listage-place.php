<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client et voiture</title>
    <link rel="stylesheet" href="Listage-place.css">
</head>
<body>
    <h1>AFFICHAGE DES PLACES LIBRES</h1>
    <a href="Place.php"><img src="images/icone3.png" class="image3"></a>
    <table>
        <thead>
            <tr>
                <th scope="col">Voiture</th>
                <th scope="col">Client</th> 
                <th scope="col">Design</th>
                <th scope="col">Type</th>
                <th scope="col">Place</th>
                <th scope="col">occupation</th>
                <th scope="col">Supprimer</th>
            </tr>
        </thead>
        <tbody>
    <?php
        include "connexion.php";
        $sql3 = "SELECT Place.Idvoit, Nom, Design, Type,Place, numero_place , occupation FROM Place,Voiture,Client 
                 WHERE Voiture.Idvoit=Place.Idvoit AND Client.IdClient=PLace.IdClient
                 ORDER BY Design ASC";
        $resultat = mysqli_query($conn, $sql3);
        
        if ($resultat) {  
            while ($row = mysqli_fetch_assoc($resultat)) {                 
                $idvoit=$row['Idvoit'];
                $IdClient=$row['Nom'];
                $design=$row['Design'];
                $Type=$row['Type'];
                $place=$row['Place'];
                $numero_place=$row['numero_place'];
                $occupation=$row['occupation'];
                    echo "<tr>
                          <th scope='col'>" .  $idvoit  . "</th>
                          <td>" . $IdClient . "</td>
                          <td>" . $design . "</td>
                          <td>" . $Type . "</td>
                          <td>" . $numero_place . "</td>
                          <td>" . $occupation . "</td>
                          <td>
                             <a href=\"Supprimer-place.php? Supprimer-placeplace='$place'\">
                             <img src=\"images/Supprimer.jpg\" width=\"30px\" heigth=\"50px\"></a>
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
