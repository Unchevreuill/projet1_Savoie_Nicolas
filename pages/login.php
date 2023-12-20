<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "votre_nom_utilisateur";
$password = "votre_mot_de_passe";
$dbname = "nom_de_votre_base_de_donnees";

// Créer une connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Traitement du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT id, password FROM User WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Vérifier le mot de passe
        if (password_verify($password, $row['password'])) {
            // Le mot de passe est correct, démarrer une session
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Aucun compte trouvé avec cet e-mail";
    }
}

mysqli_close($conn);
?>

<h2>Login</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    E-mail: <input type="email" name="email" required><br>
    Mot de passe: <input type="password" name="password" required><br>
    <input type="submit" value="Connexion">
</form>

<a href="signup.php">S'enregistrer</a></br>
<a href="../">Home</a>
