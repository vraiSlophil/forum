<!DOCTYPE html>

<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once "app/database.php";

?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <header id="header">
        <div></div>
        <div id="header__head">

        </div>
        
        <?php 
        if (isset($_SESSION['login'])) {?>

        <?php } ?>


    </header>

    <section id="new_subject">

        <h2 id="new_subject__title">
            Nouveau Sujet
        </h2>
    <div id="new_subject__formu">
        
        <?php 
        if (isset($_SESSION['login'])) {?>
            <form action="database.php" method="POST">
                <input name="nv_sujet" type="textbox" value="Entrez votre nouveau sujet"> </input>
                <input type="submit" value="Créer"> </input>    
        <?php }
        else {
            echo '<button id="new_subject__register_login" href="login.php"> Connectez-vous </button>';
        }
        ?>

    </div>
    </section>

</body>
</html>
