<?php
session_start();

// Connectez-vous à la base de données
$conn = mysqli_connect("localhost", "root", "", "site_jeux");
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

// Fonction pour ajouter un produit au panier
function ajouterAuPanier($productId) {
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    if (isset($_SESSION['panier'][$productId])) {
        $_SESSION['panier'][$productId]++;
    } else {
        $_SESSION['panier'][$productId] = 1;
    }
}

// Vérifiez si un produit a été ajouté au panier
if (isset($_POST['ajouter_au_panier'])) {
    ajouterAuPanier($_POST['product_id']);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Site de Jeux Vidéo</title>
    <link rel="stylesheet" href="../css/home.css">
</head>
<body>
    <nav class="navbar">
        <ul>
            <li><a href="produit.php">Produits</a></li>
            <li><a href="panier.php">Panier</a></li>
            <li><a href="inscription.php">Inscription</a></li>
            <li><a href="login.php">Connexion</a></li>
            <?php
            if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
                echo '<li><a href="gestion.php">Gestion</a></li>';
            }
?>
        </ul>
    </nav>

    <header class="header">
        <h1>Bienvenue sur notre site de jeux vidéo !</h1>
        <p>Découvrez les derniers jeux et accessoires.</p>
    </header>

    <section class="featured-games">
        <h2>Jeux en Vedette</h2>
        <div class="games-container">
            <?php
            $sql = "SELECT id, name, price, url_img FROM produit LIMIT 3";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="game">';
                    echo '<img src="../images/' . $row['url_img'] . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p>Prix: ' . htmlspecialchars($row['price']) . ' €</p>';
                    echo '<form method="post">';
                    echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" name="ajouter_au_panier">Ajouter au panier</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "<p>Aucun produit trouvé.</p>";
            }

            mysqli_close($conn);
            ?>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; 2023 Site de Jeux Vidéo</p>
    </footer>
</body>
</html>
