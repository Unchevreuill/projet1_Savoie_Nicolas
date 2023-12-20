<h2>Page de résultat</h2>
<?php
require_once "../config/connexion.php";
require_once"../functions/crud.php";
require_once"../functions/fonction.php";
require_once"../functions/validation.php";
echo '<h2>Mon $_POST</h2>';
var_dump($_POST);

if (isset($_POST)&& $_POST["action"]=="signup") {
    # code...

    //validation
$validationData = signupValidation($_POST);
    // si ma validation est ok je passe à la suite 
    //sinon j'affiche les messages d'erreur

    

   

    //enregistrer mon utilisateur
if ($validationData['isValid']) {
    $data = [
        'email'=>$_POST['email'],
        'password'=>($_POST['password']),
        'username'=>$_POST['username'],
    ];
    echo '<h2>Mon Data avant de creer user</h2>';
    var_dump($data);
    //die('Normalement ici je créerai un user');

    $result = createUser($data);
}
    



    //si l'enregistrement a fonctionné : rediriger vers index.php
}
//Votre enregistre,ment s'est bien effectué
//Vous etes bien connecté
?>