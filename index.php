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

if (isset($_GET["logout"]) && $_GET["logout"] && isset($_SESSION["login"])) {
    unset($_SESSION["login"]);
    header("Location: index.php");
    exit();
}

if(isset($_POST['new_subject_name']) && isset($_SESSION["login"])) {
    $new_sbjct = $_POST['new_subject_name'];
    if (strlen($new_sbjct) > 128) {
        $error = true;
        $errorLen = true;
    } else if (strpos($new_sbjct, " ") !== false || strpos($new_sbjct, "‎") !== false) {
        $error = true;
        $errorChar = true;
    } else {
        $sub = createSubject($new_sbjct, $_SESSION["login"]);
    }
}

if(isset($_POST["register_pseudo"])){
    if(!strlen($_POST["register_pseudo"]) > 24) {
        $_SESSION["pseudo_too_long"]=True;
        header("Location: register.php");
        exit();
    }

    if(isset($_POST["register_password"])){
        if($_POST["register_password"] != $_POST["register_confirm_password"]){
            $_SESSION["problem_password"] = true;
            header("Location: register.php");
            exit();
        }
        $user = createUser($_POST["register_pseudo"], $_POST["register_password"]);
        if($user != 1) {
            $_SESSION["pseudo_not_unique"] = true;
            header("Location: register.php");
            exit();
        }
        $_SESSION["login"] = getId($_POST["register_pseudo"]);
        header("Location: index.php");
        exit();
    }
}

if (isset($_POST["login_pseudo"]) && isset($_POST["login_password"])) {
    $lo = checkLogin($_POST["login_pseudo"], $_POST["login_password"]);
    if ($lo == 0){
        $_SESSION["problem_login"] = true;
        header("Location: login.php");
        exit();
    }
    $_SESSION["login"] = $lo;
    header("Location: index.php");
    exit();
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
<?php print_r($sub); ?>
    <header id="header">
        <div id="header__head">
            <img src="img/forumone.png" alt="icon" id="header__head__image">
            <h1 id="header__head__title">Forumone</h1>
        </div>
        <?php if (isset($_SESSION['login'])) {?>
            <div id="header__user">
                <div id="header__user__name">
                    <?php echo htmlspecialchars(getName($_SESSION['login'])); ?>
                </div>
                <a href="?logout=1" id="header__user__name__log_out_link">
                    <img src="img/log-out.png" alt="log out image" id="header__user__name__log_out_link__image">
                </a>
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
