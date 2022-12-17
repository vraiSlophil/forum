<!DOCTYPE html>
<?php
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

    <?php if (isset($_SESSION["problem_login"]) && $_SESSION["problem_login"]){ ?>
        <div id="error_connect">
            <p id="error_connect__message">
            <?php 
            echo "Votre mot de passe ou votre identifiant n'a pas été trouvé";
            unset($_SESSION["problem_login"]);
            ?>
            </p>
        </div>
    <?php } ?>
    <section id="login_form">
        <a href="index.php" id="login_form__home">
            Retour à l'accueil
        </a>
        <form action="index.php" method="post" id="login_form__form">
            <div id="login_form__form__name">
                <p>Votre Pseudo :</p>
                <input type="text" id="login_form__form__name__pseudo" name="login_pseudo" placeholder="Votre pseudo" required>
            </div>
            <div id="login_form__form__password">
                <p>Votre mot de passe :</p>
                <input type="password" id="login_form__form__password__password" name="login_password" placeholder="Votre mot de passe" required>
            </div>
            <input type="submit" id="login_form__form__submit" value="Se connecter">
        </form>
    </section>
    
</body>
</html>