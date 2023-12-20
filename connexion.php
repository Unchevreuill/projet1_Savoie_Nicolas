<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Formulaire de connexion</title>
    <link rel="stylesheet" href="./css/robeafricaine.css">
</head>

<body>

    <?php
    include './functions/fonction.php';




    $serveur = 'localhost';
    $utilisateur = 'root';
    $password = '';
    $baseDeDonnee = 'site_jeux';

    $connexion = mysqli_connect($serveur, $utilisateur, $password, $baseDeDonnee);
    if (!$connexion) {
        die("Connexion echoue => " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $userPassword = $_POST['password'];

        $sql = "SELECT * FROM infoutilisateur WHERE email=? ";

        $stmt = $connexion->prepare($sql);

        $stmt->bind_param("s", $email);

        $resultat = $stmt->execute();

        if ($resultat) {
            $resultat = $stmt->get_result();
            $resultatUtilisateur = $resultat->fetch_assoc();
            if (isset($resultatUtilisateur['passwords'])) {
                $verificationMdp = password_verify($userPassword, $resultatUtilisateur['passwords']);
                if ($verificationMdp) {
                    echo "<script>";
                    echo "alert('Connexion réussie, bienvenue.');";
                    echo "</script>";
                    $_SESSION['CoName'] = $email;
                    header("Refresh:0; url=index.php");
            
                } else {
                    echo "<script>";
                    echo "alert('Mot de passe incorrect.');";
                    echo "</script>";
                }
            } else {
                echo "<script>";
                echo "alert('Aucun utilisateur trouvé avec cet email.');";
                echo "</script>";
            }
        } else {
            die("Erreur lors de l'exécution de la requête : " . $stmt->error);
        }
    }
    mysqli_close($connexion);


    ?>


    <div class="FRMconnexion">
        <form action="#" method="POST">
            <br>
            <p>Connectez-vous a l'aide de l'email et du mot de passe!</p>

            <br><br>
            <label>Email: </label><br>
            <input type="text" name="email" id="email"><br><br>

            <label>Mot de passe: </label><br>
            <input type="password" name="password" id="password"><br><br>

            <button type="submit" name="submit" class="btn btn-light">Connexion</button>

        </form>
    </div>

</body>

</html>