<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="Ajouter-client.css">
</head>
<body>
    <h1>GESTION DES CLIENTS</h1>
    <form action="">
        <fieldset class="field1">
            <a href="../Acceuil.php"><button id="Acceuil" type="button">Acceuil</button></a><br><br>
            <a href="Affichage-Client.php"><button id="Client" type="button">Client</button></a><br><br>
            <a href="../Voiture/Affichage-voiture.php"><button id="Voiture" type="button">Voiture</button></a><br><br>
            <a href="../Reserver/Affichage_reserv.php"><button id="Reservation" type="button">Reservation</button></a><br><br>
        </fieldset>
    </form>
    <img src="images/Acceuil2.png" alt="" id="image2">
    <img src="images/client.png" class="image1">
    <form action="" method="post">
    <fieldset class="field">
            <img src="images/client4.png" class="image4">
        <div class="input-group">
            <label for="Nom-client" class="label">Nom du client :</label>
            <input type="text" name="NomClient" id="Nom-client" required>    
        </div><br><br>
        <div class="input-group">
            <label for="Telephone" class="label">Numero de Telephone :</label>
            <input type="text" name="Telephone" id="Telephone" required>
        </div><br><br><br>
        <button type="submit" class="Bouton1" name="Ajouter">AJOUTER</button>
    </fieldset><br><br>
    </form>
    <?php
       include('connexion.php');
       if (isset($_POST['NomClient']) && isset($_POST['Telephone']) && isset($_POST['Ajouter'])){
            $NomClient = mysqli_real_escape_string($conn, htmlspecialchars($_POST['NomClient']));
            $Telephone = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Telephone']));

            $sql = "INSERT INTO Client (Nom, NumTel) VALUES ('$NomClient', '$Telephone')";
            if (mysqli_query($conn, $sql)) {
               header('location:Affichage-Client.php');
            }
            else{
                echo "l'insertion n'est pas insere" . mysqli_error($conn);
            }
       }
        mysqli_close($conn);
    ?>
    
    <script src="jquery-3.7.1.js"></script>
    <script>
    $(document).ready(function () {
        $('#searchInput').on('input', function () {
            var query = $(this).val().toLowerCase();
            $('#clientTable tbody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(query) > -1);
            });
        });
    });
    </script>

</body>
</html>