<!-- <?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site_jeux";

// Créer une connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérifier la connexion
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Traitement du formulaire d'inscription
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'signup') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_DEFAULT));

    // Insérer les données de l'utilisateur dans la base de données
    $sql = "INSERT INTO User (email, password, username) VALUES ('$email', '$password', '$username')";

    if (mysqli_query($conn, $sql)) {
        echo "Inscription réussie!";
    } else {
        echo "Erreur lors de l'inscription : " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<h2>S'enregistrer</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input hidden type="text" name="action" value="signup">
    <label for="username">Nom d'utilisateur</label>
    <input id="username" type="text" name="username" required>
    <label for="email">Courriel</label>
    <input id="email" type="email" name="email" required>
    <label for="password">Mot de passe</label>
    <input id="password" type="password" name="password" required>
    <button type="submit">S'enregistrer</button>
</form>

<a href="../">Home</a> -->
