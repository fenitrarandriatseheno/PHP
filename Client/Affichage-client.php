<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Client et voiture</title>
    <link rel="stylesheet" href="Affichage-Client.css">
</head>
<body>
    <h1>AFFICHAGE DE LA LISTE DES CLIENTS</h1>
    <h2>Ajouter</h2>
    <?php
        include "connexion.php";
        $sql = "SELECT * FROM Client ORDER BY IdClient ASC";
        $resultat = mysqli_query($conn, $sql);

        mysqli_close($conn);
    ?>
    <a href="../Acceuil.php"><img src="images/icone3.png" class="image3"></a>
    <a href="Ajouter-client.php"><img src="images/client4.png" class="image4"></a>
    <form>
        <div class="recherche">
            <label for="">Recherche : <input type="text" name="Nom" id="searchInput" placeholder="Rechercher..."></label>
        </div>
    </form>

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
                if ($resultat) {
                    while ($row = mysqli_fetch_assoc($resultat)) {
                        $IdClient = $row['IdClient'];
                        $Nom = $row['Nom'];
                        $Telephone = $row['Numtel'];
                        echo '<tr>
                                <th scope="col">'.$IdClient.'</td>
                                <td>'.$Nom.'</td>
                                <td>'.$Telephone.'</td>
                                <td>
                                    <a href="Modifier-client.php?Modifier-clientIdClient='.$IdClient.'"><img src="images\modifier1.png" width="30px" height="30px"></a>
                                </td> 
                                <td>
                                    <a href="Supprimer-client.php?Supprimer-ClientIdClient='.$IdClient.'"><img src="images\Supprimer.jpg" width="30px" height="30px"></a>
                                </td> 
                            </tr>';
                    }
                } else {
                    echo "<tr><td>Aucun résultat trouvé</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('searchInput');

            searchInput.addEventListener('input', function () {
                var inputValue = searchInput.value;

                // Effectuer une requête AJAX pour mettre à jour les resultats
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        document.getElementById('clientTable').innerHTML = xhr.responseText;
                    }
                };

                xhr.open('GET', 'recherche-dynamique.php?Nom=' + inputValue, true);
                xhr.send();
            });
        });
    </script>
</body>
</html>
