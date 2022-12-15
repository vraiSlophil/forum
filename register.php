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
    <title>Enregistrement - Forumone</title>
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

    <?php if (isset($_SESSION["problem_password"]) && $_SESSION["problem_password"]){ ?>
        <div id="error_connect">
            <p id="error_connect__message">
            <?php 
            echo "Votre mot de passe n'est pas le même dans les deux champs.";
            unset($_SESSION["problem_login"]);
            ?>
            </p>
        </div>
    <?php } 
    if (isset($_SESSION["pseudo_too_long"]) && $_SESSION["pseudo_too_long"]){ ?>

        <div id="error_connect">
            <p id="error_connect__message">
            <?php 
            echo "Votre pseudo est trop long";
            unset ($_SESSION["pseudo_too_long"]);
            ?>
            </p>
        </div>

    <?php } 
    if (isset($_SESSION["pseudo_not_unique"]) && $_SESSION["pseudo_not_unique"]){ ?>

        <div id="error_connect">
            <p id="error_connect__message">
            <?php 
            echo "Ce pseudo est déjà présent dans notre base de données, veuillez en choisir un autre.";
            unset ($_SESSION["pseudo_not_unique"]);
            ?>
            </p>
        </div>

    <?php } ?>
    <section id="register_form">
        <a href="index.php" id="register_form__home">
            Retour à l'accueil
        </a>
        <form action="index.php" method="post" id="register_form__form">
            <div id="register_form__form__name">
                <p>Votre pseudo :</p>
                <input type="text" id="register_form__form__name__pseudo" name="register_pseudo" placeholder="Votre pseudo" required>
            </div>
            <div id="register_form__form__password">
                <p>Votre mot de passe :</p>
                <input type="password" id="register_form__form__password__password" name="register_password" placeholder="Votre mot de passe" required>
            </div>
            <div id="register_form__form__confirm_password">
                <p>Confirmer votre mot de passe :</p>
                <input type="password" id="register_form__form__confirm_password__password" name="register_confirm_password" placeholder="Confirmez votre mot de passe" required>
            </div>
            <input type="submit" id="register_form__form__submit" value="Créer un compte">
        </form>
    </section>

</body>
</html>