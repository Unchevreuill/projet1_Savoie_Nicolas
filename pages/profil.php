<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connectez-vous à la base de données
$conn = mysqli_connect("localhost", "root", "", "site_jeux");
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Récupérez les informations de l'utilisateur actuellement connecté
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM user WHERE id = $user_id";
$result_user = mysqli_query($conn, $sql_user);

if (mysqli_num_rows($result_user) > 0) {
    $user_data = mysqli_fetch_assoc($result_user);
} else {
    die("Utilisateur non trouvé.");
}

// Récupérez les commandes de l'utilisateur
$sql_orders = "SELECT * FROM `order` WHERE id_user = $user_id";
$result_orders = mysqli_query($conn, $sql_orders);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="../css/profil.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="home.php">Accueil</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="profil-container">
        <h1>Profil de <?= htmlspecialchars($user_data['username']) ?></h1>
        <h2>Adresse de livraison</h2>
        <p><strong>Email:</strong> <?= htmlspecialchars($user_data['email']) ?></p>
        <p><strong>Adresse de facturation:</strong> <?= htmlspecialchars($user_data['Billing_adress']) ?></p>
        <p><strong>Adresse de livraison:</strong> <?= htmlspecialchars($user_data['shipping_address']) ?></p>

        <h2>Modifier l'adresse de livraison</h2>
        <form action="modifier_adresse.php" method="POST">
            <label for="nouvelle_adresse">Nouvelle adresse de livraison:</label>
            <input type="text" name="nouvelle_adresse" id="nouvelle_adresse" required>
            <button type="submit" name="modifier_adresse">Modifier</button>
        </form>

        <h2>Historique des commandes</h2>
        <table>
            <tr>
                <th>Numéro de commande</th>
                <th>Référence</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
            <?php
            if (mysqli_num_rows($result_orders) > 0) {
                while ($row = mysqli_fetch_assoc($result_orders)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ref']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['total']) . " €</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Aucune commande trouvée.</td></tr>";
            }
            ?>
        </table>
    </div>

    <footer class="footer">
        <p>&copy; 2023 Site de Jeux Vidéo</p>
    </footer>
</body>
</html>
