<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include_once "app/database.php";

$error = false;
$errorLen = false;
$errorChar = false;

$rights = false;
$connected = false;

if (isset($_SESSION["login"])) {
    $connected = true;
    $permission = getPermission($_SESSION["login"])[0]["permission"];
    if ($permission != "administrateur" || $permission != "moderateur") {
        $rights = true;
    }
}

if (isset($_POST["delete_id_subject"])) {
    $idsbjct = $_POST["delete_id_subject"];
    $idauteur = getSubjectAuteur($idsbjct)[0][0];
    if ( $idauteur == $_SESSION["login"] || $rights) {
        deleteSubject($idsbjct);
    }
}

if (isset($_POST["load"])) {
    $load = $_POST["load"]+20;
    header("Location: index.php");
    exit();
}

$load = 20;

if (isset($_GET["logout"]) && $_GET["logout"] && $connected) {
    unset($_SESSION["login"]);
    header("Location: index.php");
    exit();
}

if(isset($_POST['new_subject_name']) && $connected) {
    $new_sbjct = $_POST['new_subject_name'];
    if (strlen($new_sbjct) > 128) {
        $error = true;
        $errorLen = true;
    } else if (!preg_match('/[^A-Za-z0-9\p{P}\p{S}\p{L}]/', $new_sbjct)) { //inderdit certains caractères
        $error = true;
        $errorChar = true;
    } else {
        $sub = createSubject($new_sbjct, $_SESSION["login"]);
        header("Location: index.php");
        exit();
    }
}

if(isset($_POST["register_pseudo"])){
    if(strlen($_POST["register_pseudo"]) > 24) {
        $_SESSION["pseudo_too_long"] = true;
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
        $_SESSION["login"] = getId($_POST["register_pseudo"])[0]["id"];
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
    <header id="header">
        <div id="header__head">
            <img src="img/forumone.png" alt="icon" id="header__head__image">
            <div id="header__head__title">
                <h1 id="header__head__title__title">Forumone</h1>
                <p id="header__head__title__sub_title">Forum de conseil en séduction</p>
            </div>
        </div>
        <?php if ($connected) {?>
            <div id="header__user">
                <div id="header__user__name">
                    <?php echo htmlspecialchars(getName($_SESSION['login'])); ?>
                </div>
                <a href="?logout=1" id="header__user__name__log_out_link">
                    <img src="img/log-out.png" alt="log out image" id="header__user__name__log_out_link__image">
                </a>
                <?php if ($rights) { ?>
                <a href="admin.php" id="header__user__name__admin_link">
                    <img src="img/personal-security.png" alt="admin image" id="header__user__name__admin_link__image">
                </a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div id="header__links">
                <a href="register.php" id="header__links__register">S'enregistrer</a>
                <a href="login.php" id="header__links__login">Se connecter</a>
            </div>
        <?php } ?>
    </header>

    <section id="subjects">
        <?php foreach(getSubjects($load) as $values) { ?>
        <div id="subjects__list">
            <div id="subjects__list__element">
                <a href="subject.php?id=<?php echo $values["id"]; ?>" id="subjects__list__element__link">
                    <?php echo htmlspecialchars($values["titre"]); ?>
                </a>
                <?php if ($connected) {
                if($_SESSION['login'] == $values["idauteur"] || $rights) { ?>
                <form action="#" method="post" id="subjects__list__element__delete">
                    <input type="hidden" name="delete_id_subject" value="<?php echo $values["id"] ?>">
                    <input type="image" id="subjects__list__element__delete__image" src="img/delete.png" alt="delete">
                </form>
                <?php }
                } ?>
                <p id="subjects__list__element__name">
                    par <?php echo htmlspecialchars(getName($values["idauteur"])); ?>
                </p>
            </div>
        </div>
        <?php }
        if (count(getSubjects($load)) >= $load) { ?>
        <form action="#" method="post" id="subjects__more_sub">
            <input type="hidden" name="load" value="<?php echo $load; ?>">
            <input type="submit" value="Voir plus">
        </form>
        <?php } else if(count(getSubjects($load)) == 0) { ?>
        <p id="messages__no_messages">
            Il n'y a pas de message dans ce sujet.
        </p>
        <?php } ?>

    </section>
    <div id="new_subject">
        <?php if ($error) {
            if ($errorLen) { ?>
                <p id="new_subject__error">
                    La taille du sujet de doit pas excéder les 128 caractères
                </p>
            <?php }
            if ($errorChar) { ?>
                <p id="new_subject__error">
                    Impossible d'utliser l'espace ou le caractère invisible dans le nom du sujet
                </p>
            <?php }
        } ?>
        <p id="new_subject__title">
            Nouveau sujet :
        </p>
        <div id="new_subject__formu">
            <?php
            if (isset($_SESSION['login'])) {
            ?>
            <form action="#" method="post" id="new_subject__formu__form">
                <input id="new_subject__formu__form__name" name="new_subject_name" type="textbox" placeholder="Entrez votre nouveau sujet">
                <input id="new_subject__formu__form__submit" type="submit" value="Créer">
            </form>
            <?php } else { ?>
            <a id="new_subject__formu__register_login" href="login.php">Connectez-vous</a>
            <?php } ?>
        </div>
    </div>

</body>
</html>
