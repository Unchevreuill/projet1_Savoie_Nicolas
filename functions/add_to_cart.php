<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "site_jeux");

if (isset($_POST['add_to_cart'])) {
    $userId = $_POST['user_id'];
    $productId = $_POST['product_id'];
    $quantite = 1; // Ou une quantité spécifiée par l'utilisateur

    $sql = "INSERT INTO panier (id_user, id_produit, quantite) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $userId, $productId, $quantite);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: home.php"); // Redirigez l'utilisateur où vous voulez après l'ajout
    exit();
}
?>
