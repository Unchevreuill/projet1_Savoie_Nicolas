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

    $serveur = "localhost";
    $username = "root";
    $password = "";
    $database = "site_jeux";
    $connexion = mysqli_connect($serveur, $username, $password, $database);

    if (!$connexion) {
        die("Échec de la connexion à la base de données : " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        $email = mysqli_real_escape_string($connexion, $_POST['email']);
        $password = mysqli_real_escape_string($connexion, $_POST['password']);
        $username = mysqli_real_escape_string($connexion, $_POST['username']); // Ajouté username
        $password = password_hash($password, PASSWORD_DEFAULT);

        // Validation des champs
        if (empty($email) || empty($password) || empty($username)) {
            echo "<script>alert('Veuillez remplir tous les champs.');</script>";
        } else {
            $emailExistsQuery = "SELECT COUNT(*) FROM user WHERE email = ?";
            $stmt = $connexion->prepare($emailExistsQuery);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($emailCount);
            $stmt->fetch();
            $stmt->close();

            if ($emailCount > 0) {
                echo "<script>alert('Cet email est déjà enregistré.');</script>";
            } else {
                // Ajout de valeurs par défaut pour Billing_adress, role_id et shipping_address
                $requeteSQL = "INSERT INTO user (email, pwd, username, Billing_adress, role_id, shipping_address) VALUES (?, ?, ?, 1, 2, 1)";
                $stmt = $connexion->prepare($requeteSQL);
                $stmt->bind_param('sss', $email, $password, $username);
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
            <label for="username">Nom d'utilisateur: </label><br>
            <input type="text" name="username" id="username" required><br><br>
            <label for="email">Email: </label><br>
            <input type="email" name="email" id="email" required><br><br>
            <label for="password">Mot de passe: </label><br>
            <input type="password" name="password" id="password" required><br><br>

            <button type="submit" name="submit" class="btn">Enregistrer</button>
        </form>
    </div>
</body>

</html>
