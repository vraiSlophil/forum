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
    <link rel="stylesheet" href="css/style.css">
    <title>Connexion - Forumone</title>
</head>
<body>
    <header id="header">
        <div id="header__head">
            <img src="img/forumone.png" alt="icon" id="header__head__image">
            <div id="header__head__title">
                <h1 id="header__head__title__title">Forumone</h1>
                <p id="header__head__title__sub_title">Forum de conseil en séduction</p>
            </div>
        </div>
    </header>
    <?php 
    if (isset($_SESSION["problem_password"]) && $_SESSION["problem_password"]){
        echo "Votre confirmation de mot de passe et votre mot de passe ne sont pas les mêmes";
        unset ($_SESSION["problem_password"]);
    }

    if (isset($_SESSION["pseudo_too_long"]) && $_SESSION["pseudo_too_long"]){
        echo "Votre pseudo est trop long";
        unset ($_SESSION["pseudo_too_long"]);
    }
    if (isset($_SESSION["pseudo_not_unique"]) && $_SESSION["pseudo_not_unique"]){
        echo "Un autre utilisateur utilise déjà votre pseudo";
        unset ($_SESSION["pseudo_not_unique"]);
    }
    ?>
<form action="index.php" method="post" id="form">
    <h1>Créer votre pseudo :</h1> 
    <input type="text" name="register_pseudo" required>
    <h1>Créer votre mot de passe :</h1>
    <input type="password" name="register_password" required>
    <h1>Confirmer votre mot de passe :</h1>
    <input type="password" name="register_confirm_password" required>
    <input type="submit" value="Valider">
</form> 
</body>
</html>