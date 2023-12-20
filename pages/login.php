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

    $sql = "SELECT id, password FROM User WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php");
            exit();
        } else {
            $messageErreur = "Mot de passe incorrect";
        }
    } else {
        $messageErreur = "Aucun compte trouvé avec cet e-mail";
    }
}

mysqli_close($conn);
?>

<h2>Login</h2>
<?php if ($messageErreur != "") { echo "<p>$messageErreur</p>"; } ?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    E-mail: <input type="email" name="email" required><br>
    Mot de passe: <input type="password" name="password" required><br>
    <input type="submit" value="Connexion">
</form>

<a href="signup.php">S'enregistrer</a></br>
<a href="../">Home</a>
