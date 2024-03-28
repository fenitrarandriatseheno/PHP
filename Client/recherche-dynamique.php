<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client et voiture</title>
    <link rel="stylesheet" href="Affichage-Client.css">
</head>
<body>
    <div>
        <table id="clientTable">
            <thead>
                <tr id="ligne">
                    <th scope='col'>IdClient</th>
                    <th scope='col'>Nom</th>
                    <th scope='col'>Telephone</th>
                    <th scope='col'>Modifier</th>
                    <th scope='col'>Supprimer</th>
                </tr>
            </thead>
            <tbody>
    <?php
    include "connexion.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['Nom'])) {
        $Nom = isset($_GET['Nom']) ? htmlspecialchars($_GET['Nom']):htmlspecialchars($_GET['Numtel']);
        $sql = "SELECT * FROM Client WHERE Nom LIKE '%" . $Nom . "%' OR Numtel LIKE '%" .$Nom."%' ORDER BY IdClient ASC";
        $resultat = mysqli_query($conn, $sql);

        if ($resultat) {
            while ($row = mysqli_fetch_assoc($resultat)) {
                $IdClient = $row['IdClient'];
                $Nom = $row['Nom'];
                $Telephone = $row['Numtel'];
                echo '<tr>
                        <th scope="col">' . $IdClient . '</td>
                        <td>' . $Nom . '</td>
                        <td>' . $Telephone . '</td>
                        <td>
                            <a href="Modifier-client.php?Modifier-clientIdClient=' . $IdClient . '"><img src="images\modifier1.png" width="30px" height="30px"></a>
                        </td> 
                        <td>
                            <a href="Supprimer-client.php?Supprimer-ClientIdClient=' . $IdClient . '"><img src="images\Supprimer.jpg" width="30px" height="30px"></a>
                        </td> 
                    </tr>';
            }
        } else {
            echo "<tr><td>Aucun résultat trouvé</td></tr>";
        }
        
        mysqli_close($conn);
    } else {
        echo "Erreur dans la requête.";
    }
        ?>

            </tbody>
        </table>
    </div>
</body>
</html>