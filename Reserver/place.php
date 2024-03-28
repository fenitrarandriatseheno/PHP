<?php
include "connexion.php";

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Ajouter'])) {
        // Récupérer les données du formulaire
        $Idvoit = isset($_POST['select1']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['select1'])) : null;
        $place = isset($_POST['place']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['place'])) : null;
        $radio = isset($_POST['radio']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['radio'])) : null;
        $Nom = isset($_POST['select']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['select'])) : null;
        $checkbox = isset($_POST['Type']) ? strtoupper(mysqli_real_escape_string($conn, htmlspecialchars($_POST['Type']))) : null;

        // Vérifier si la place est déjà réservée pour la voiture sélectionnée
        $sqlCheckDoublon = "SELECT * FROM place WHERE Idvoit = '$Idvoit' AND numero_place = '$place'";
        $resultCheckDoublon = mysqli_query($conn, $sqlCheckDoublon);

        if (mysqli_num_rows($resultCheckDoublon) > 0) {
            echo "<script>alert('Cette place est déjà réservée. Veuillez choisir une autre place.');</script>";
        } else {
            // Vérifier le type de voiture et le nombre de places disponibles
            switch ($checkbox) {
                case 'VIP':
                    $maxPlaces = 12;
                    break;
                case 'PREMIUM':
                    $maxPlaces = 16;
                    break;
                case 'SIMPLE':
                    $maxPlaces = 18;
                    break;
                default:
                    echo "Type de voiture inconnu";
                    exit(); // Arrêter l'exécution en cas de type de voiture inconnu
            }

            // Vérifier si le nombre de places ne dépasse pas la limite
            if ($place > $maxPlaces) {
                echo "<script>alert(\"$checkbox ne contient que $maxPlaces places\");</script>";
            } else {
                $sql="SELECT IdClient FROM Client WHERE Nom='$Nom'";
                $result=mysqli_query($conn,$sql);
                $clientRow = mysqli_fetch_assoc($result);
                $clientId = $clientRow['IdClient'];
                $sqlInsertPlace = "INSERT INTO place(Idvoit, IdClient, numero_place, occupation) VALUES ('$Idvoit', '$clientId', '$place', '$radio')";

                if (!mysqli_query($conn, $sqlInsertPlace)) {
                    echo "Erreur lors de l'ajout de l'enregistrement dans la table Place : " . mysqli_error($conn);
                }
            }
        }
    }
}

if (isset($_POST['select1']) && isset($_POST['select']) && isset($_POST['Retour'])) {
    $Idvoit = mysqli_real_escape_string($conn, htmlspecialchars($_POST['select1']));
    $Nom = mysqli_real_escape_string($conn, htmlspecialchars($_POST['select']));
    $sql="SELECT IdClient FROM Client WHERE Nom='$Nom'";
    $result=mysqli_query($conn,$sql);
    $clientRow = mysqli_fetch_assoc($result);
    $clientId = $clientRow['IdClient'];
    $sqlplace = "SELECT numero_place FROM place WHERE IdClient=$clientId AND Idvoit='$Idvoit'";
    $resultplace = mysqli_query($conn, $sqlplace);

    if ($resultplace && mysqli_num_rows($resultplace) > 0) {
        // Rediriger vers la page Ajouter-reserver.php seulement si une place est choisie
        header("Location: essaiplace.php?placeIdvoit=" . $Idvoit ."&&placeIdClient=".$clientId."");
        exit();
    } else {
        // Afficher une alerte si aucune place n'est choisie
        echo "<script>alert('Veuillez choisir une place avant de cliquer sur Retour.');</script>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation de place</title>
    <link rel="stylesheet" href="Place.css">
    <script>
        function updateReservedPlaces() {
            var selectedIdvoit = document.getElementById('select1').value;

            // Effectuer une requête AJAX pour mettre à jour les places réservées
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var reservedPlaces = JSON.parse(xhr.responseText);

                    // Mettre à jour la couleur des cases réservées
                    for (var i = 1; i <= 20; i++) { // Modifier le nombre de places en fonction de votre besoin
                        var element = document.querySelector("td[name='" + i + "']");
                        if (reservedPlaces.includes(i.toString())) {
                            element.style.backgroundColor = 'red';
                        } else {
                            element.style.backgroundColor = 'green';
                        }
                    }
                }
            };

            xhr.open('GET', 'updateReservedPlaces.php?Idvoit=' + selectedIdvoit, true);
            xhr.send();
        }
    </script>
</head>
<body>
    <form action="" method="post">
        <h2>Les places déjà réservées :</h2>
        <div class="">
            <label for="" class="Idvoiture">Identifiant de la voiture :</label>
            <select name="select1" id="select1" class="select1" onchange="updateReservedPlaces()">
                <?php
                include "connexion.php";
                $sqlIds = "SELECT Idvoit FROM Voiture";
                $resultIds = mysqli_query($conn, $sqlIds);

                if ($resultIds) {
                    while ($rowId = mysqli_fetch_assoc($resultIds)) {
                        echo "<option value='" . $rowId['Idvoit'] . "'>" . $rowId['Idvoit'] . "</option>";
                    }
                } else {
                    echo "Erreur lors de la récupération des identifiants de la table Voiture : " . mysqli_error($conn);
                }
                mysqli_close($conn);
                ?>
            </select><br><br>
        </div>
        <div>
            <label for="" class="IdClient">Nom du Client :</label>
            <select name="select" class="select">    
            <?php
            include "connexion.php";
                $sqlIdCli = "SELECT Nom FROM Client";
                $resultIdCli = mysqli_query($conn, $sqlIdCli);

                if ($resultIdCli) {
                    while ($rowId = mysqli_fetch_assoc($resultIdCli)) {
                         echo "<option value='" . $rowId['Nom'] . "'>" . $rowId['Nom'] . "</option>";
                    }
            } else {
                echo "Erreur lors de la recuperation des identifiants de la table Client : " . mysqli_error($conn);
            }
            mysqli_close($conn);
            ?>
        </select><br><br>
        </div>
        <h1>Veuillez choisir votre place :</h1>
        <table>
        <?php
                include "connexion.php";

                // Récupération des places réservées
                $Idvoit = isset($_POST['select1']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['select1'])) : '';
                $sqlReservedPlaces = "SELECT numero_place FROM place WHERE Idvoit = ? AND occupation = 'OUI'";
                $stmtReservedPlaces = mysqli_prepare($conn, $sqlReservedPlaces);
                mysqli_stmt_bind_param($stmtReservedPlaces, "i", $Idvoit);
                mysqli_stmt_execute($stmtReservedPlaces);
                $resultReservedPlaces = mysqli_stmt_get_result($stmtReservedPlaces);

                $reservedPlaces = array();
                if ($resultReservedPlaces) {
                    while ($rowReservedPlace = mysqli_fetch_assoc($resultReservedPlaces)) {
                        $reservedPlaces[] = $rowReservedPlace['numero_place'];
                    }
                } else {
                    echo "Erreur lors de la récupération des places réservées : " . mysqli_error($conn);
                }

                // Génération du tableau de places
                for ($i = 1; $i <= 5; $i++) {
                    echo "<tr>";
                    for ($j = 1; $j <= 4; $j++) {
                        $placeNumber = ($i - 1) * 4 + $j;
                        $backgroundColor = in_array($placeNumber, $reservedPlaces) ? 'red' : 'green';
                        echo "<td style='background-color: $backgroundColor' name='$placeNumber'>$placeNumber</td>";
                    }
                    echo "</tr>";
                }
                ?>
        </table>

        <div id="type-container">
            <label for="" class="choix1">Type de voiture :</label>
            <select name="Type" class="choix">
                <option value="VIP">VIP</option>
                <option value="PREMIUM">PREMIUM</option>
                <option value="SIMPLE">SIMPLE</option>
            </select><br><br>
        </div>
        <fieldset>
            <!--<div class="Boite1"></div>-->
            <br><br>
            <label for="" class="place">Place réservée :</label>
            <input type="number" name="place" id="place" oninput="updateReservedPlaces()">
            <br><br>
            <label for="" class="occupation">Occupation :</label>
            <label for="" class="oui"><input type="radio" name="radio" value="OUI" id="OUI">OUI</label><br>
            <label for="" class="non"><input type="radio" name="radio" value="NON" id="NON">NON</label><br><br>
        </fieldset>
        <button type="submit" id="Ajout" name="Ajouter" onclick="updateReservedPlaces()">Confirmer</button>
        <button type="submit" id="Retour" name="Retour">Retour</button>
        <a href="Listage-place.php"><button type="button" id="Affichage">Affichage des place libres</button></a>
    </form>
</body>
</html>
