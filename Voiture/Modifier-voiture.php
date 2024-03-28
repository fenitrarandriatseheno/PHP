<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier voiture</title>
    <link rel="stylesheet" href="Modifier-Voiture.css">
</head>
<body>
    <div class="Boite1"></div>
    <div class="Boite2"></div>
    <div class="Boite3"></div>
    <div class="Boite4"></div>
    <?php
       include('connexion.php');
       $idvoit=$_GET['Modifier-voitureIdvoit'];
       $sqlmod="SELECT * FROM Voiture WHERE Idvoit='$idvoit'";
       $resmod=mysqli_query($conn,$sqlmod);
       $row=mysqli_fetch_assoc($resmod);
       $Design=$row['Design'];  
       $typeVehicule=$row['Type']; 
       $nbr_place=$row['nbr_place'];  
       $frais=$row['Frais']; 
       
       if (isset($_POST['Identifiant']) && isset($_POST['Design']) && isset($_POST['checkbox']) 
           && isset($_POST['Nombre_de_place']) && isset($_POST['frais']) && isset($_POST['Modifier'])){
            $idvoit = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Identifiant']));
            $Design = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Design']));
            $checkbox = mysqli_real_escape_string($conn, htmlspecialchars($_POST['checkbox']));
            $Nombre_de_place = mysqli_real_escape_string($conn, htmlspecialchars($_POST['Nombre_de_place']));
            $frais= mysqli_real_escape_string($conn, htmlspecialchars($_POST['frais']));

                $sql = "UPDATE Voiture SET Idvoit='$idvoit', Design='$Design',Type='$checkbox' 
                    ,nbr_place='$Nombre_de_place' , Frais=$frais WHERE Idvoit='$idvoit'";
                    if (mysqli_query($conn, $sql)) {
                        header('location:Affichage-voiture.php');
                        }
                    else{
                        echo "l'modification n'est pas valide" . mysqli_error($conn);
            }
        }
        mysqli_close($conn);
    ?>

    <h1>Modification des voitures</h1>
    <div class="Boite1"></div>
    <form action="" method="post">
        <fieldset class="field">
                <legend>VOITURE</legend>
                <div class="input-group">
                    <label for="Identifiant">Identifiant :</label>
                    <input type="text" name="Identifiant" id="Identifiant" value=<?php echo $idvoit; ?> required><br><br>
                    <label for="Design">Design :</label>
                    <input type="text" name="Design" id="Design" value=<?php echo $Design; ?> required>
                </div><br>
                <div>
                    <label for="type-de-voiture" class="choix1">Type de voiture :</label>
                    <select name="checkbox" value="<?php echo $typeVehicule; ?>" class="choix">
                        <option value="VIP">VIP</option>
                        <option value="PREMIUM">PREMIUM</option>
                        <option value="SIMPLE">SIMPLE</option>
                    </select><br><br>
                 </div>

                <div>
                    <label for="Nombre_de_place" class="Nombre_de_place">Nombre de place :</label>
                    <select name="Nombre_de_place" value=<?php echo $nbr_place; ?> class="nombre-place">
                        <option value="12">12</option>
                        <option value="16">16</option>
                        <option value="18">18</option>
                    </select><br><br>
                    <label for="frais" class="frais">Frais :</label>
                    <input type="text" name="frais" value=<?php echo $frais; ?> placeholder="..............ar" id="frais">
                </div>
                <button type="submit" class="Bouton1" name="Modifier">Modifier</button>
            </fieldset><br>
    </form>
</body>
</html>