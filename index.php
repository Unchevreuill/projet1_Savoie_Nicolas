<?php
require_once('functions/fonction.php');
require_once "functions/crud.php";
require_once "config/connexion.php";

// Redirection vers accueil.php dans le sous-dossier pages
header('Location: pages/home.php');
exit();
?>