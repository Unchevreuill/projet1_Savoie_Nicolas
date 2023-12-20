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
