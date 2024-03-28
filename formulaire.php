<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
    <link rel="stylesheet" href="php-formulaire.css">
</head>
<body>
   <div class="contenaire">
    <div class="wrapper">
        <div class="form-wrapper sign in">
            <form action="" method="post">
                <h2>Login</h2>
                <div class="input-group">
                    <input type="text" name="Email" required>
                    <label for="">EMAIL</label>
                </div>
                <div class="input-group">
                    <input type="password" name="Mot_de_passe" required>
                    <label for="">MOT DE PASSE</label>
                </div>
                <div class="remember">
                    <label ><input type="checkbox">remember me</label>
                </div>
                <button type="submit">Login</button>
                <div class="singUp-link">
                    <p>D'ont have an account? <a href="#" class="singBtn-link">Sing up</a></p>
                </div>
            </form>
        </div>
    </div>
    <span style="--i:0;"></span>
    <span style="--i:1;"></span>
    <span style="--i:2;"></span>
    <span style="--i:3;"></span>
    <span style="--i:4;"></span>
    <span style="--i:5;"></span>
    <span style="--i:6;"></span>
    <span style="--i:7;"></span>
    <span style="--i:8;"></span>
    <span style="--i:9;"></span>
    <span style="--i:10;"></span>
    <span style="--i:11;"></span>
    <span style="--i:12;"></span>
    <span style="--i:13;"></span>
    <span style="--i:14;"></span>
    <span style="--i:15;"></span>
    <span style="--i:16;"></span>
    <span style="--i:17;"></span>
    <span style="--i:18;"></span>
    <span style="--i:19;"></span>
    <span style="--i:20;"></span>
    <span style="--i:21;"></span>
    <span style="--i:22;"></span>
    <span style="--i:23;"></span>
    <span style="--i:24;"></span>
    <span style="--i:25;"></span>
    <span style="--i:26;"></span>
    <span style="--i:27;"></span>
    <span style="--i:28;"></span>
    <span style="--i:29;"></span>
  </div>
  
  <?php
include('connexion.php');

function validerEmail($email) {
    $pattern = "/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

    return preg_match($pattern, $email);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email1 = $_POST["Email"];
    $mot_de_passe = $_POST["Mot_de_passe"];

    if (validerEmail($email1)) {
        $query = "SELECT Email,Mot_de_passe FROM User WHERE Email='$email1' AND Mot_de_passe='$mot_de_passe'";
        $result = mysqli_query($connexion, $query);
    
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                header('location:Acceuil.php');
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        } else {
            echo "Erreur dans la requete SQL: " . mysqli_error($connexion);
        }
    } else {
        echo "Email non valide.";
    }
}  
?>


</body>
</html>