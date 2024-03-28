<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserver</title>
    <link rel="stylesheet" href="Modifier-reserv.css">
</head>
<body>
    <h4>Modidification des reservations</h4>
    <div class="Boite1"></div>
    <div class="Boite2"></div>
    <?php
    include('connexion.php');
    $Idreserv = $_GET['Modifier-reservIdreserv'];
    $date_reserv = $_GET['Modifier_reservdate_reserv'];
    $sqlmod = "SELECT * FROM reserver WHERE Idreserv='$Idreserv' AND date_reserv='$date_reserv'";
    $resmod = mysqli_query($conn, $sqlmod);
    $row = mysqli_fetch_assoc($resmod);
    $Idvoit = $row['Idvoit'];
    $IdClient = $row['IdClient'];
    $place = $row['Place'];
    $datevoyage = $row['date_voyage'];
    $payement = $row['payement'];
    $Montant_avance = $row['Montant_avance'];

    if (isset($_POST['Idvoit']) && isset($_POST['IdClient'])
        && isset($_POST['place']) && isset($_POST['date'])
        && isset($_POST['payement']) && isset($_POST['Montant']) && isset($_POST['Modifier'])) {
        $Idvoit = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Idvoit']));
        $IdCli = mysqli_real_escape_string($conn, htmlspecialchars($_POST['IdClient']));
        $place = mysqli_real_escape_string($conn, htmlspecialchars($_POST['place']));
        $date = htmlspecialchars($_POST['date']);
        $payement = mysqli_real_escape_string($conn, htmlspecialchars($_POST['payement']));
        $Montant = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Montant']));
        $sql = "UPDATE reserver 
                SET Idvoit='$Idvoit',IdClient='$IdCli',Place='$place',date_voyage='$date',payement='$payement',Montant_avance='$Montant'
                WHERE Idreserv='$Idreserv' AND date_reserv='$date_reserv'";
        $sql2 = "UPDATE Place SET numero_place='$place' WHERE Idvoit='$Idvoit' AND IdClient='$IdCli'";

        if (mysqli_query($conn, $sql)) {
            if (mysqli_query($conn, $sql2)) {
                header('location:Affichage_reserv.php');
                exit(); 
            }
        } else {
            echo "Modification n'est pas valide" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
    ?>
    <form action="" method="post">
            <div>
                <label for="" class="Idvoiture">Identifiant Voiture :</label>
                <select name="Idvoit" class="select1" value="<?php echo $Idvoit; ?>">
                    <?php
                    include "connexion.php";
                    $sqlIds = "SELECT Idvoit FROM Voiture";
                    $resultIds = mysqli_query($conn, $sqlIds);

                    if ($resultIds) {
                        while ($rowId = mysqli_fetch_assoc($resultIds)) {
                            $selected = ($rowId['Idvoit'] == $Idvoit) ? 'selected' : '';
                            echo "<option value='" . $rowId['Idvoit'] . "' $selected>" . $rowId['Idvoit'] . "</option>";
                        }
                    } else {
                        echo "Erreur lors de la récupération des identifiants de la table Voiture : " . mysqli_error($conn);
                    }

                    mysqli_close($conn);
                    ?>
                </select><br><br>
            </div>
            <div>
                <label for="" class="IdClient">Identifiant Client :</label>
                <select name="IdClient" class="select4" value="<?php echo $IdClient; ?>">
                    <?php
                    include "connexion.php";
                    $sqlIdCli = "SELECT IdClient FROM Client";
                    $resultIdCli = mysqli_query($conn, $sqlIdCli);

                    if ($resultIdCli) {
                        while ($rowId = mysqli_fetch_assoc($resultIdCli)) {
                            $selected = ($rowId['IdClient'] == $IdClient) ? 'selected' : '';
                            echo "<option value='" . $rowId['IdClient'] . "' $selected>" . $rowId['IdClient'] . "</option>";
                        }
                    } else {
                        echo "Erreur lors de la récupération des identifiants de la table Client : " . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                    ?>
                </select><br><br>
            </div>

            <div>
                <label for="" class="place">Place:</label>
                <input type="text" name="place" id="place" value="<?php echo $place; ?>">
                <br><br>
            </div>
            <div>
                <label for="" class="date">Date de voyage :</label>
                <input type="text" name="date" id="date" value="<?php echo $datevoyage; ?>"><br><br>
            </div>
            <div>
                <label for="" class="payement">Payement :</label>
                <select name="payement" id="payement">
                    <option value="sans_avance" <?php echo ($payement == 'sans_avance') ? 'selected' : ''; ?>>Sans avance</option>
                    <option value="avec avance" <?php echo ($payement == 'avec avance') ? 'selected' : ''; ?>>Avec avance</option>
                    <option value="tout payer" <?php echo ($payement == 'tout payer') ? 'selected' : ''; ?>>Tout payer</option>
                </select><br><br>
            </div>
            <div>
                <label for="" class="Montant">Montant en avance :</label>
                <input type="text" name="Montant" id="Montant" oninput="calculerReste()" value="<?php echo isset($Montant_avance) ? $Montant_avance : ''; ?>"><br><br>
            </div>

            <div>
                <label for="" class="prix">Prix total :</label>
                <select name="prix" id="prix" onchange="calculerReste()">
                    <?php
                    include "connexion.php";
                    $sqlFrais = "SELECT Frais FROM Voiture";
                    $resultFrais = mysqli_query($conn, $sqlFrais);

                    if ($resultFrais) {
                        while ($rowFrais = mysqli_fetch_assoc($resultFrais)) {
                            $selected = ($rowFrais['Frais'] == $Montant_avance) ? 'selected' : '';
                            echo "<option value='" . $rowFrais['Frais'] . "' $selected>" . $rowFrais['Frais'] . "</option>";
                        }
                    } else {
                        echo "Erreur lors de la récupération des identifiants de la table Client : " . mysqli_error($conn);
                    }
                    mysqli_close($conn);
                    ?>
                </select><br><br>
            </div>
            <div>
                <label for="" class="reste">Reste à payer :</label>
                <input type="text" name="Reste_payer" id="Reste_payer" readonly value="<?php echo isset($Reste_payer) ? $Reste_payer : ''; ?>"><br><br>
            </div>

            <script>
                function calculerReste() {
                    var montant = parseInt(document.getElementById('Montant').value) || 0;
                    var prix = parseInt(document.getElementById('prix').value) || 0;
                    var restePayer = prix - montant;
                    document.getElementById('Reste_payer').value = restePayer;
                }
            </script>

            <button type="submit" id="Modifier" name="Modifier">Modifier</button>
            <a href="Affichage_reserv.php"><button type="button" class="Retour" name="Retour">Retour</button></a><br><br>
    </form>
</body>
</html>