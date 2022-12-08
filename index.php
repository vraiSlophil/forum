<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include_once "app/database.php";

$error = false;

$errorLen = false;
$errorChar = false;

$load = 20;

if(isset($_POST['new_subject_name'])) {
    $new_sbjct = $_POST['new_subject_name'];
    if (strlen($new_sbjct) > 128) {
        $error = true;
        $errorLen = true;
    } elseif(str_contains($new_sbjct, " ") || str_contains($new_sbjct, "‎")) {
        $error = true;
        $errorChar = true;
    } else {
        createSubject($_SESSION["login"], $new_sbjct);
    }
}

if(isset($_POST["register_pseudo"])){
    if(!strlen($_POST["register_pseudo"]) > 24) {
        $_SESSION["pseudo_too_long"]=True;
        header("Location: register.php");
        exit();
    }

    if (!uniqueName($_POST["register_pseudo"])) {
        $_SESSION["pseudo_not_unique"]=True;
        header("Location: register.php");
        exit();
    }

    if(isset($_POST["register_password"])){
        if($_POST["register_password"] != $_POST["register_confirm_password"]){
            $_SESSION["problem_password"] = true;
            header("Location: register.php");
            exit();
        }
        createUser($_POST["register_pseudo"], $_POST["register_password"]);
        $_SESSION["login"] = getId($_POST["register_pseudo"]);
    }
}

if (isset($_POST["login_pseudo"])){
    if (isset($_POST["login_password"])){
        if (checkLogin($_POST["login_pseudo"],$_POST["login_password"])==0){
            $_SESSION["problem_login"]=True;
            header("Location: login.php");
            exit();
        } else {
            $_SESSION["login"] = checkLogin($_POST["login_pseudo"], $_POST["login_password"]);
        }
    }   

}

?>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/forumone.png">
    <link rel="stylesheet" href="css/style.css">
    <title>Accueil - Forumone</title>
</head>
<body>
    <header id="header">
        <div id="header__head">
            <img src="img/forumone.png" alt="icon" id="header__head__image">
            <h1 id="header__head__title">Forumone</h1>
        </div>
        <?php if (isset($_SESSION['login'])) {?>
            <div id="header__user_name">
                <?php echo htmlspecialchars(getName($_SESSION['login'])); ?>
            </div>
        <?php } else { ?>
            <div id="header__links">
                <a href="register.php" id="header__links__register">S'enregistrer</a>
                <a href="login.php" id="header__links__login">Se connecter</a>
            </div>
        <?php } ?>
    </header>

    <section id="subjects">

        <div id="subjects__list">
        <?php foreach(getSubjects($load) as $values) { ?>
            <div id="subjects__list__element">
                <a href="subject.php?id=<?php echo $values["id"]; ?>" id="subjects__list__element__link">
                    <?php echo htmlspecialchars($values["titre"]); ?>
                </a>
                <p id="subjects__list__element__name">
                    par <?php echo htmlspecialchars(getName($values["idauteur"])); ?>
                </p>
            </div>
            <?php } ?>
        </div>
    
        <div id="subjects__new_subject">
            <h2 id="subjects__new_subject__title">
                Nouveau sujet
            </h2>
            <?php if ($error) { 
                 if ($errorLen) { ?>
            <h3 id="subjects__new_subject__error">
                La taille du sujet de doit pas excéder les 128 caractères
            </h3>
                <?php } 
                if ($errorChar) { ?>
            <h3 id="subjects__new_subject__error">
                Impossible d'utliser l'espace ou le caractère invisible dans le nom du sujet
            </h3>
                <?php }
            } ?>
            <div id="subjects__new_subject__formu">
                <?php
                if (isset($_SESSION['login'])) {
                ?>
                <form action="#" method="POST">
                    <input id="subjects__new_subject__formu__name" name="new_subject_name" type="textbox" value="Entrez votre nouveau sujet">
                    <input id="subjects__new_subject__formu__submit" type="submit" value="Créer">
                </form>
                <?php } else { ?>
                <button id="new_subject__register_login" href="login.php">Connectez-vous</button>
                <?php } ?>
            </div>
        </div>
    </section>

</body>
</html>
