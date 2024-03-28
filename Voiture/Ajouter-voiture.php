<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajout voiture</title>
    <link rel="stylesheet" href="Ajouter-voiture.css">
</head>
<body>
    <form action="">
        <fieldset class="field1">
            <a href="../Acceuil.php"><button id="Acceuil" type="button">Acceuil</button></a><br><br>
            <a href="../Client/Affichage-client.php"><button id="Client" type="button">Client</button></a><br><br>
            <a href="Affichage-voiture.php"><button id="Voiture" type="button">Voiture</button></a><br><br>
            <a href="../Reserver/Affichage_reserv.php"><button id="Reservation" type="button">Reservation</button></a><br><br>
        </fieldset>
    </form>
    <h1>Gestions des voitures</h1>
    <form action="" method="post">
        <fieldset class="field">
                <div class="input-group">
                    <label for="Identifiant">Identifiant :</label>
                    <input type="text" name="Identifiant" id="Identifiant" required><br><br>
                    <label for="Design">Design :</label>
                    <input type="text" name="Design" id="Design" required>
                </div><br>
                <div class="choix">
                    <label for="type-de-voiture">Type de voiture :</label><br><br>
                    <label id="nom-voiture"><input type="checkbox" id="type-de-voiture" name="checkbox" value="SIMPLE">SIMPLE</label><br>
                    <label id="nom-voiture"><input type="checkbox" id="type-de-voiture" name="checkbox" value="PREMIUM">PREMIUM</label><br>
                    <label id="nom-voiture"><input type="checkbox" id="type-de-voiture" name="checkbox" value="VIP">VIP</label><br>
                </div><br>
                <div class="nombre-place">
                    <label for="Nombre_de_place">Nombre de place :</label>
                    <select name="Nombre_de_place" class="nombre-place">
                        <option value="16">16</option>
                        <option value="18">18</option>
                        <option value="12">12</option>
                    </select><br><br>
                    <label for="frais">Frais :</label>
                    <input type="text" name="frais" placeholder="..............ar" id="frais">
                </div>
                <button type="submit" class="Bouton1" name="Ajouter">AJOUTER</button>
            </fieldset><br>
    </form>
    <img src="img/suprinter" alt="" class="voiture">
    <?php
       include('connexion.php');
       if (isset($_POST['Identifiant']) &&  isset($_POST['Design']) && isset($_POST['checkbox']) 
          && isset($_POST['Nombre_de_place']) && isset($_POST['frais']) && isset($_POST['Ajouter'])) {
       $Identifiant = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Identifiant']));
       $Design = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Design']));
       $checkbox = mysqli_real_escape_string($conn, htmlspecialchars($_POST['checkbox']));
       $Nombre_de_place = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Nombre_de_place']));
       $frais = mysqli_real_escape_string($conn, htmlspecialchars($_POST['frais']));

            $sql2 = "INSERT INTO Voiture (Idvoit, Design, Type, nbr_place, Frais) 
            VALUES ('$Identifiant','$Design', '$checkbox', '$Nombre_de_place', $frais)";
     
            if (mysqli_query($conn, $sql2)) {
                header('location:Affichage-voiture.php');
            } else {
                echo "Erreur lors de l'ajout de l'enregistrement dans la table Client : " . mysqli_error($conn);
            }
    }
    mysqli_close($conn);
    ?>
</body>
</html>