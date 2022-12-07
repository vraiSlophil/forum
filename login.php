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
    if ($_SESSION["problem_login"]==True){
        echo "Votre mot de passe ou votre identifiant n'a pas été trouvé";
    }
    ?>
    <form action="index.php" method="post" id="form">
        <h1>Votre Pseudo :</h1>
        <input type="text" name="login_pseudo" require>
        <h1>Votre mot de passe :</h1>
        <input type="password" name="login_password" require>
    </form>
</body>
</html>