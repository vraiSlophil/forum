<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("database.php");
$bdd = sql_connect();
?>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>LOGIN</title>
    </head>
    <body>
    <form action="tempo/tempologin.php" method="post" id="form">
        <h1>Pseudo :</h1> 
        <h1>Votre mot de passe :</h1>
            <select name="mdp1">
            </select>
        <h1>Confirmer votre mot de passe :</h1>
            <select name="mdp2"></select>
        <?php

        ?>
        <input type="submit" value="Valider"></input>
    </form> 
    </body>
</html>