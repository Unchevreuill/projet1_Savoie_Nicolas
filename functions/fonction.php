<?php
session_start();
function quantiterPanier()
{

    if (!isset($_SESSION["panier"])) {
        $_SESSION['panier'] = [0];
        $_SESSION['paniercount'] = 0;
        $_SESSION['total'] = 0;
    }
    if (!isset($_SESSION["paniercount"])) {
        $_SESSION['panier'] = [0];
        $_SESSION['paniercount'] = 0;
        $_SESSION['total'] = 0;
    }
    $compteElement = $_SESSION['paniercount'];

    return $compteElement;
}
function addPanier()
{
    if (!isset($_SESSION["panier"])) {
        $_SESSION['panier'] = [0];
        $_SESSION['paniercount'] = 0;
        $_SESSION['total'] = 0;
    }
    if (!isset($_SESSION["paniercount"])) {
        $_SESSION['panier'] = [0];
        $_SESSION['paniercount'] = 0;
        $_SESSION['total'] = 0;
    }
    array_push($_SESSION['panier'], (int)$_POST['ajouter']);
    $_SESSION["paniercount"] = $_SESSION["paniercount"] + 1;
    echo '<script>console.log(' . json_encode($_SESSION["panier"]) . ')</script>';
}

function delPanier()
{
    if (!isset($_SESSION["panier"])) {
        $_SESSION['panier'] = [0];
        $_SESSION['paniercount'] = 0;
    }
    if (!isset($_SESSION["paniercount"])) {
        $_SESSION['panier'] = [0];
        $_SESSION['paniercount'] = 0;
    }
    //array_splice($_SESSION['panier'],(int)$_POST['del'],1);
    foreach ($_SESSION['panier'] as $key) {
        if ($key == $_POST['del']) {
            $find = array_search($_POST['del'], $_SESSION['panier']);
            echo '<script>console.log(' . $find . ')</script>';

            //unset($_SESSION['panier'],$key);
        }
    }
    //array_splice($_SESSION['panier'],$_POST['del'],1);
    array_splice($_SESSION['panier'], $find, 1);

    if ($_SESSION['paniercount'] > 0) {
        $_SESSION["paniercount"] = $_SESSION["paniercount"] - 1;
    }
}

//function
function aficher_conection()
{

    $CoName = "";

    if (!isset($_SESSION["CoName"])) {
        $CoName = '<a href="connexion.php"><button type="button" class="btn btn-success">Login</button></a>';
    } else {
        $CoName = '<button type="button" id="CoNameShow" class="btn btn-info">' . $_SESSION["CoName"] . '<a href="logout.php"></button><button type="button" class="btn btn-danger">Logout</button></a>';
    }

    return $CoName;
}

function trueCo()
{
    $inscri = "";
    if (!isset($_SESSION["CoName"])) {
        $inscri = '<a class="nav-link" href="inscription.php">Inscription</a>';
    } else {
        $inscri = '<a class="nav-link disabled" href="inscription.php">Inscription</a>';
    }
    return $inscri;
}
function getProductById($productId) {
    // Connexion à la base de données
    $conn = mysqli_connect("localhost", "root", "", "site_jeux");
    
    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM produit WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $productId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_close($conn);
        return $row;
    } else {
        mysqli_close($conn);
        return null;
    }
}
