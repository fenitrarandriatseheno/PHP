<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link rel="stylesheet" href="Modifier-Client.css">
</head>
<body>
    <div class="Boite1"></div>
    <div class="Boite2"></div>
    <div class="Boite3"></div>
    <div class="Boite4"></div>
    <?php
       include('connexion.php');
       $IdClient=$_GET['Modifier-clientIdClient'];
       $sqlmod="SELECT * FROM Client WHERE IdClient=$IdClient";
       $resmod=mysqli_query($conn,$sqlmod);
       $row=mysqli_fetch_assoc($resmod);
       $NomClient=$row['Nom'];
       $Telephone=$row['Numtel']; 
       
       if (isset($_POST['NomClient']) && isset($_POST['Telephone']) && isset($_POST['Modifier'])){
            $NomClient = mysqli_real_escape_string($conn, htmlspecialchars($_POST['NomClient']));
            $Telephone = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Telephone']));

            $sql = "UPDATE Client SET IdClient=$IdClient, Nom='$NomClient',Numtel='$Telephone' WHERE IdClient=$IdClient";
            if (mysqli_query($conn, $sql)) {
               header('location:Affichage-Client.php');
            }
            else{
                echo "l'modification n'est pas valide" . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    ?>
    <h1>MODIFICATION DES CLIENTS</h1>
    <form action="" method="post">
    <fieldset class="field">
    <legend>CLIENT</legend>
        <h2>Modification :</h2>
        <div class="input-group">
            <label for="Nom-client" class="label">Nom du client :</label>
            <input type="text" name="NomClient" id="Nom-client" required value=<?php echo $NomClient; ?>>    
        </div><br><br>
        <div class="input-group">
            <label for="Telephone" class="label">Numero de Telephone :</label>
            <input type="text" name="Telephone" id="Telephone" required value=<?php echo $Telephone;?>>
        </div><br><br><br>
        <button type="submit" class="Bouton1" name="Modifier">Mofifier</button>
    </fieldset><br><br>
    </form>
</body>
</html>