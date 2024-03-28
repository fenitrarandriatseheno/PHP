<?php
        include "connexion.php";
        if ( isset($_POST['select1']) && isset($_POST['select']) 
            && isset($_POST['place']) && isset($_POST['datetime']) && isset($_POST['date']) && 
            isset($_POST['payement']) && isset($_POST['Montant']) && isset($_POST['Ajouter'])) {
            $Idvoit = mysqli_real_escape_string($conn, htmlspecialchars($_POST['select1']));
            $Nom = mysqli_real_escape_string($conn, htmlspecialchars($_POST['select']));
            $place = mysqli_real_escape_string($conn, htmlspecialchars($_POST['place']));
            $datetime = htmlspecialchars($_POST['datetime']);
            $date = htmlspecialchars($_POST['date']);
            $payement = mysqli_real_escape_string($conn, htmlspecialchars($_POST['payement']));
            $Montant = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Montant']));

            // Convertir la chaîne en tableau en utilisant la virgule comme séparateur
            $placesArray = explode(',', $place);

            // Convertir chaque élément en entier et les joindre avec des virgules
            $placesString = implode(',', array_map('intval', $placesArray));

            $sql="SELECT IdClient FROM Client WHERE Nom='$Nom'";
            $result=mysqli_query($conn,$sql);
            $clientRow = mysqli_fetch_assoc($result);
            $clientId = $clientRow['IdClient'];

            $sql2 = "INSERT INTO reserver( Idvoit, IdClient, place, date_reserv, date_voyage, payement, Montant_avance)
            VALUES ( '$Idvoit', $clientId,'$place','$datetime', '$date', '$payement', '$Montant')";

            if (mysqli_query($conn, $sql2)) {
                header('location: Affichage_reserv.php');
            }else {
                echo "Erreur lors de l'ajout de l'enregistrement dans la table Client : " . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserver</title>
    <link rel="stylesheet" href="essai_place.css">
</head>
<body>
    <form action="">
        <fieldset class="field1">
            <img src="../images/Acceuil.png" alt="" id="image2">
            <a href="../Acceuil.php"><button id="Acceuil" type="button">Acceuil</button></a><br><br>
            <img src="../images/Acceuil2.png" alt="" id="image3">
            <a href="../Client/Affichage-client.php"><button id="Client" type="button">Client</button></a><br><br>
            <img src="images/voiture2.jpg" alt="" id="image4">
            <a href="../Voiture/Affichage-voiture.php"><button id="Voiture" type="button">Voiture</button></a><br><br>
        </fieldset>
    </form>
    <h4>Reservation</h4>
       <div>
    <form action="" method="post">
        <div class="">
            <label for="" class="Idvoiture">Identifiant voiture :</label>
            <select name="select1" class="select1" value="<?php echo $Idvoit; ?>">
            <?php
            include "connexion.php";
                $sqlIds = "SELECT Idvoit FROM Voiture";
                $resultIds = mysqli_query($conn, $sqlIds);

                if ($resultIds) {
                    while ($rowId = mysqli_fetch_assoc($resultIds)) {
                        echo "<option value='" . $rowId['Idvoit'] . "'>" . $rowId['Idvoit'] . "</option>";
                    }
                } else {
                        echo "Erreur lors de la recuperation des identifiants de la table Voiture : " . mysqli_error($conn);
               }

            mysqli_close($conn);
            ?>
        </select><br><br>
        </div>
        <div>
            <label for="" class="IdClient">Nom du Client :</label>
            <select name="select" class="select4" value="<?php echo $IdClient; ?>">    
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
        
        <div>
        <?php
            include "connexion.php";

            $place = ""; 

            if (isset($_GET['placeIdvoit']) && isset($_GET['placeIdClient'])) {
                $Idvoit = $_GET['placeIdvoit'];
                $IdClient = $_GET['placeIdClient'];
                $sql = "SELECT GROUP_CONCAT(CAST(numero_place AS char)) AS place FROM Place WHERE IdClient=$IdClient AND Idvoit='$Idvoit' GROUP BY Idvoit";
                $sqlres = mysqli_query($conn, $sql);

                if ($sqlres) {
                    $row = mysqli_fetch_assoc($sqlres);
                    $place = $row['place'];
                } else {
                    echo "Erreur lors de la récupération des données : " . mysqli_error($conn);
                }
            }

            mysqli_close($conn);
            ?>

            <label for="" class="place">Place:</label>
            <input type="text" id="place" name="place" value="<?php echo isset($place) ? $place : ''; ?>" readonly><br><br>
            <a href="place.php"><button type="button" id="choix_place">Choix place </button></a>
        </div>
        
        <div>
            <label for="" class="date-reserv">Date de Reservation :</label>
            <input type="text" name="datetime" id="datetime" placeholder="AAAA/MM/JJ HH:mn:ss"><br><br>
        </div>
       
        <div>
            <label for="" class="date-voyage">Date de voyage :</label>
            <input type="text" name="date" id="date" placeholder="AAAA/MM/JJ"><br><br>
        </div>
        
        <div>
            <label for="" class="payement">payement :</label>
            <select name="payement" id="payement">
                    <option value="sans_avance">Sans avance</option>
                    <option value="avec avance">Avec avance</option>
                    <option value="tout payer">Tout payer</option>
            </select><br><br>
        </div>
        <div>
            <label for="" class="Montant">Montant en avance :</label>
            <input type="text" name="Montant" id="Montant" placeholder="Ariary" oninput="calculerReste();" value="<?php echo isset($Montant) ? $Montant : ''; ?>"><br><br>
        </div>

        <div>
            <label for="" class="prix">Prix total :</label>
            <select name="Prix" id="prix" onchange="calculerReste();">
            <?php
            include "connexion.php";
                $sqlFrais = "SELECT DISTINCT Frais FROM Voiture";
                $resultFrais = mysqli_query($conn, $sqlFrais);

            if ($resultFrais) {
                while ($rowFrais = mysqli_fetch_assoc($resultFrais)) {
                     echo "<option value='" . $rowFrais['Frais'] . "'>" . $rowFrais['Frais'] . "</option>";
                }
            } else {
                echo "Erreur lors de la recuperation des identifiants de la table Client : " . mysqli_error($conn);
            }
            mysqli_close($conn);
            ?>
        </select><br><br>
        </div>
        
        <div>
            <label for="" class="reste">Reste à payer :</label>
            <input type="text" name="Reste_payer" id="Reste_payer" placeholder="Ariary" readonly value="<?php echo isset($Reste_payer) ? $Reste_payer : ''; ?>"><br><br>
        </div>
            <script>
            function calculerReste() {
                    var montant = parseInt(document.getElementById('Montant').value) || 0;
                    var prix = parseInt(document.getElementById('prix').value) || 0;
                    var restePayer = prix - montant;
                    if (prix<montant) {
                        //alert("veillez entrez une nouvelle montant car votre montant est superieur au prix");
                        document.getElementById('Reste_payer').value = 0;
                    }else{
                        document.getElementById('Reste_payer').value = restePayer;
                    }
                }
            </script>

        <div>
            <button type="submit" id="Ajout" name="Ajouter">Ajouter</button>
        </div>
    </form>
        <a href="Affichage_reserv.php"><button type="button" class="Affichage">Affichage des reservations</button></a>
        <a href="../Affichage_reservation.php"><button type="button" class="recu">Recu</button></a>
</body>
</html>