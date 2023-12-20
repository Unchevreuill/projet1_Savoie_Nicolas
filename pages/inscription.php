<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="./css/inscription.css">
</head>

<body>

    <?php
    include './includes/fonction.php';


    $serveur = "localhost";
    $username = "root";
    $password = "";
    $database = "site_jeux";

    $connexion = mysqli_connect($serveur, $username, $password, $database);

    if (!$connexion) {
        die("echec de la connexion a la base de donnee:" . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $nom = mysqli_real_escape_string($connexion, $nom);
        $prenom = mysqli_real_escape_string($connexion, $prenom);
        $telephone = mysqli_real_escape_string($connexion, $telephone);
        $email = mysqli_real_escape_string($connexion, $email);
        $password = mysqli_real_escape_string($connexion, $password);

        $password = password_hash($password, PASSWORD_DEFAULT);

        if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($password)) {
            echo "<script>";
            echo "alert('Veuillez remplir tous les champs.');";
            echo "</script>";
        } else {
            // Vérifier si l'email est déjà enregistré
            $emailExistsQuery = "SELECT COUNT(*) FROM infoutilisateur WHERE email = ?";
            $stmt = $connexion->prepare($emailExistsQuery);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($emailCount);
            $stmt->fetch();
            $stmt->close();

            if ($emailCount > 0) {
                echo "<script>";
                echo "alert('Cet email est déjà enregistré.');";
                echo "</script>";
            } else {
                $requeteSQL = "INSERT INTO infoutilisateur (nom, prenom, telephone, email, passwords) VALUES (?,?,?,?,?)";
                $stmt = $connexion->prepare($requeteSQL);
                $stmt->bind_param('sssss', $nom, $prenom, $telephone, $email, $password);

                $resultat = $stmt->execute();
                if ($resultat) {
                    echo "<script>";
                    echo "alert('Utilisateur enregistré.');";
                    echo "</script>";
                } else {
                    echo "<script>";
                    echo "alert('Une erreur est survenue.');";
                    echo "</script>";
                }
            }
        }
    }
    ?>

    <div class="FRMinscription">
        <form action="#" method="POST">
            <h1><u>Bienvenue!</u></h1>
            <p>Veuillez remplir les champs suivants!</p>
            <label>Nom: </label><br>
            <input type="text" name="nom" id="nom" require><br><br>
            <label>Prenom: </label><br>
            <input type="text" name="prenom" id="prenom" require><br><br>
            <label>Email: </label><br>
            <input type="email" name="email" id="email" require><br><br>
            <label>Numero de telephone: </label><br>
            <input type="number" name="telephone" id="telephone" require><br><br>
            <label>Mot de passe: </label><br>
            <input type="password" name="password" id="password" require><br><br>

            <button type="submit" name="submit" class="btn btn-light">Enregistrer</button>
        </form>
    </div>
</body>

</html>