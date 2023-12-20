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

        <?php
        include '../functions/fonction.php';

        // Initialisation du panier s'il n'existe pas
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        // Traitement de la suppression d'un article
        if (isset($_POST['del'])) {
            delPanier($_POST['del']);
            // Recharge la page pour mettre à jour l'affichage du panier
            header("Location: panier.php");
            exit();
        }

        // Affichage des articles dans le panier
        if (count($_SESSION['panier']) == 0) {
            echo '<p>Le panier est vide</p>';
        } else {
            $total = 0;
            foreach ($_SESSION['panier'] as $id) {
                $product = getProductById($id);

                echo '<div class="product">
                        <h3>' . htmlspecialchars($product['titre']) . '</h3>
                        <p>' . htmlspecialchars($product['description']) . '</p>
                        <p>Prix : ' . htmlspecialchars($product['prix']) . ' €</p>
                        <form method="post">
                            <button type="submit" name="del" value="' . htmlspecialchars($id) . '">Supprimer</button>
                        </form>
                      </div>';
                $total += $product['prix'];
            }
            echo '<div class="total"><p>Total : ' . $total . ' €</p></div>';
        }
        ?>
    </div>
</body>
</html>
