<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
?>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/forumone.png">
    <title>Connexion - Forumone</title>
</head>
<body>
    <?php 
    if ($_SESSION["problem_password"]==True){
        echo "Votre confirmation de mot de passe et votre mot de passe ne sont pas les mêmes";
        unset ($_SESSION["problem_password"]);
    } 
    if ($_SESSION["pseudo_too_long"]==True){
        echo "Votre pseudo est trop long";
        unset ($_SESSION["pseudo_too_long"]);
    }
    if ($_SESSION["pseudo_not_unique"]){
        echo "Un autre utilisateur utilise déjà votre pseudo"
        unset ($_SESSION["pseudo_not_unique"])
    }
    ?>
<form action="index.php" method="post" id="form">
    <h1>Créer votre pseudo :</h1> 
    <input type="text" name="register_pseudo" require>
    <h1>Créer votre mot de passe :</h1>
    <input type="password" name="register_password" require>
    <h1>Confirmer votre mot de passe :</h1>
    <input type="password" name="register_confirm_password" require>
    <input type="submit" value="Valider"></input>
</form> 
</body>
</html>