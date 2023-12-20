<?php
include '../functions/fonction.php';

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Traitement de la suppression d'un article
if (isset($_POST['del'])) {
    delPanier($_POST['del']);
    header("Location: panier.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier d'achat</title>
    <link rel="stylesheet" type="text/css" href="../css/panier.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Votre Panier</h1>
        </div>

        <div class="products-container">
            <?php
            if (count($_SESSION['panier']) == 0) {
                echo '<p>Le panier est vide</p>';
            } else {
                $total = 0;
                foreach ($_SESSION['panier'] as $id => $quantity) {
                    $product = getProductById($id);

                    echo '<div class="product">';
                    echo '<img src="../images/' . $product['url_img'] . '" alt="' . htmlspecialchars($product['name']) . '">';
                    echo '<div class="product-details">';
                    echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($product['description']) . '</p>';
                    echo '<p>Prix unitaire : ' . htmlspecialchars($product['price']) . ' €</p>';
                    echo '<p>Quantité : ' . $quantity . '</p>';
                    echo '</div>';
                    echo '<form method="post">';
                    echo '<button type="submit" name="del" value="' . htmlspecialchars($id) . '">Supprimer</button>';
                    echo '</form>';
                    echo '</div>';

                    $total += $product['price'] * $quantity;
                }
                echo '<div class="total"><p>Total : ' . $total . ' €</p></div>';
            }
            ?>
        </div>
    </div>
</body>
</html>
