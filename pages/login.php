<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site_jeux";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$messageErreur = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Utilisation d'une requête préparée pour éviter les injections SQL
    $sql = "SELECT id, pwd FROM user WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['pwd'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php"); // Redirige vers la page d'accueil après la connexion réussie
            exit();
        } else {
            $messageErreur = "Mot de passe incorrect";
        }
    } else {
        $messageErreur = "Aucun compte trouvé avec cet e-mail";
    }
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="../css/login.css"> 
</head>
<body>
    <div class="login-container">
        <h2>Connexion</h2>
        <?php if ($messageErreur != ""): ?>
            <p class="error-message"><?= htmlspecialchars($messageErreur) ?></p>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Connexion">
            </div>
        </form>
        <a href="inscription.php">S'enregistrer</a><br>
        <a href="../">Home</a>
    </div>
</body>
</html>
