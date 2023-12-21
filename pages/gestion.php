<?php
// Vérifiez si l'utilisateur est connecté en tant qu'administrateur
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header("Location: access_denied.php"); // Redirigez vers la page d'accès refusé si l'utilisateur n'est pas administrateur
    exit();
}

// Incluez votre fichier de configuration de la base de données
require_once("config.php");

// Fonction pour récupérer l'historique des commandes
function getCommandHistory($conn) {
    $query = "SELECT * FROM commandes";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Fonction pour ajouter un nouveau produit
function addNewProduct($conn, $nomProduit, $description, $prix) {
    $query = "INSERT INTO produits (nom, description, prix) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssd", $nomProduit, $description, $prix);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

// Traitement du formulaire d'ajout de produit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter_produit"])) {
    $nomProduit = $_POST["nom_produit"];
    $description = $_POST["description"];
    $prix = floatval($_POST["prix"]);

    if (addNewProduct($conn, $nomProduit, $description, $prix)) {
        echo "Produit ajouté avec succès.";
    } else {
        echo "Erreur lors de l'ajout du produit.";
    }
}

// Récupération de l'historique des commandes
$commandHistory = getCommandHistory($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestion</title>
</head>
<body>
    <h1>Historique des commandes</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Client</th>
            <th>Total</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($commandHistory)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['client']; ?></td>
                <td><?php echo $row['total']; ?></td>
            </tr>
        <?php } ?>
    </table>

    <h2>Ajouter un nouveau produit</h2>
    <form method="POST" action="gestion.php">
        <label for="nom_produit">Nom du produit:</label>
        <input type="text" name="nom_produit" required><br>
        <label for="description">Description:</label>
        <textarea name="description" required></textarea><br>
        <label for="prix">Prix:</label>
        <input type="number" name="prix" step="0.01" required><br>
        <input type="submit" name="ajouter_produit" value="Ajouter">
    </form>
</body>
</html>

<?php
// Fermez la connexion à la base de données à la fin de la page
mysqli_close($conn);
?>
