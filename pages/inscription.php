<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Formulaire d'inscription</title>
    <link rel="stylesheet" href="../css/inscription.css">
</head>

<body>

    <?php
    include '../functions/fonction.php';

    // Connexion à la base de données
    $serveur = "localhost";
    $username = "root";
    $password = "";
    $database = "site_jeux";
    $connexion = mysqli_connect($serveur, $username, $password, $database);

    if (!$connexion) {
        die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
        $prenom = mysqli_real_escape_string($connexion, $_POST['prenom']);
        $telephone = mysqli_real_escape_string($connexion, $_POST['telephone']);
        $email = mysqli_real_escape_string($connexion, $_POST['email']);
        $password = mysqli_real_escape_string($connexion, $_POST['password']);

        $password = password_hash($password, PASSWORD_DEFAULT);

        // Validation des champs
        if (empty($nom) || empty($prenom) || empty($email) || empty($telephone) || empty($password)) {
            echo "<script>alert('Veuillez remplir tous les champs.');</script>";
        } else {
            // Requête pour vérifier si l'email existe déjà
            $emailExistsQuery = "SELECT COUNT(*) FROM infoutilisateur WHERE email = ?";
            $stmt = $connexion->prepare($emailExistsQuery);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($emailCount);
            $stmt->fetch();
            $stmt->close();

            if ($emailCount > 0) {
                echo "<script>alert('Cet email est déjà enregistré.');</script>";
            } else {
                // Requête pour insérer l'utilisateur
                $requeteSQL = "INSERT INTO infoutilisateur (nom, prenom, telephone, email, passwords) VALUES (?, ?, ?, ?, ?)";
                $stmt = $connexion->prepare($requeteSQL);
                $stmt->bind_param('sssss', $nom, $prenom, $telephone, $email, $password);
                $resultat = $stmt->execute();
                if ($resultat) {
                    echo "<script>alert('Utilisateur enregistré.');</script>";
                } else {
                    echo "<script>alert('Une erreur est survenue.');</script>";
                }
            }
        }
    }
    ?>

    <div class="frm-inscription">
        <form action="inscription.php" method="POST">
            <h1><u>Bienvenue!</u></h1>
            <p>Veuillez remplir les champs suivants!</p>
            <label for="nom">Nom: </label><br>
            <input type="text" name="nom" id="nom" required><br><br>
            <label for="prenom">Prenom: </label><br>
            <input type="text" name="prenom" id="prenom" required><br><br>
            <label for="email">Email: </label><br>
            <input type="email" name="email" id="email" required><br><br>
            <label for="telephone">Numero de telephone: </label><br>
            <input type="number" name="telephone" id="telephone" required><br><br>
            <label for="password">Mot de passe: </label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit" name="submit" class="btn">Enregistrer</button>
        </form>
    </div>
</body>

</html>
