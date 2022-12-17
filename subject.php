<!DOCTYPE html>
<?php
session_start();

if (!isset($_GET["id"])) {
    header("Location: index.php");
    exit();
}

include_once "app/database.php";
$connected = false;
$rights = false;
$conseiller = false;

if (isset($_POST["load"])) {
    $load = $_POST["load"]+50;
    header("Location: subject.php?id=" .$_GET["id"]);
    exit();
}

$load = 50;

if (isset($_SESSION["login"])) {
    $connected = true;
    if (getPermission($_SESSION['login'])[0]["permission"] == "moderateur" || getPermission($_SESSION['login'])[0]["permission"] == 'administrateur') {
        $rights = true;
    }
}

if (isset($_POST["delete_id_message"])) {
    $idmsg = $_POST["delete_id_message"];
    $idauteur = getAuteur($idmsg)[0][0];
    if ( $idauteur == $_SESSION["login"] || $rights = true) {
        deleteMessage($idmsg);
        header("Location: subject.php?id=" .$_GET["id"]);
        exit();
    }
}

if (isset($_POST["like_message_id"])) {
    modifyLikes($_POST["like_message_id"], $_SESSION["login"]);
    header("Location: subject.php?id=" .$_GET["id"]);
    exit();
}

if (isset($_POST["write_message"])) {
    addMessages($_SESSION['login'], $_GET['id'], $_POST["write_message"]);
    header("Location: subject.php?id=" .$_GET["id"]);
    exit();
}

$titre = htmlspecialchars(getTitle($_GET['id'])[0]["titre"]);
$messages = getMessages($_GET['id'], $load);
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/forumone.png">
    <title><?php print_r($titre); ?> - Forumone</title>
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
        <?php if (isset($_SESSION['login'])) {?>
            <div id="header__user">
                <div id="header__user__name">
                    <?php echo htmlspecialchars(getName($_SESSION['login'])); ?>
                </div>
                <a href="index.php?logout=1" id="header__user__name__log_out_link">
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
    <section id="messages">
        <div id="messages__home">
            <a href="index.php" id="messages__home__link">
                Retour à l'accueil
            </a>
        </div>
        <h1 id="messages__subject_title">
            <?php echo $titre; ?>
        </h1>
        <div id="messages__list">
        <?php foreach($messages as $values){ ?>
            <div id="messages__list__element">
                <p id="messages__list__element__message">
                    <?php echo htmlspecialchars($values["contenu"]); ?>
                </p>
            <?php if ($connected) { ?>
                <form action="#" method="post" id="messages__list__element__like_form">
                    <p id="messages__list__element__like_form__like">
                        <?php echo getLikes($values["id"])[0]["COUNT(*)"]; ?>
                    </p>
                    <input type="hidden" name="like_message_id" value="<?php echo $values['id']; ?>">
                    <input type="image" id="messages__list__element__like_form__image" src="img/like.png" alt="like">
                </form>
                <?php if($_SESSION['login'] == $values["idauteur"] || $rights) { ?>
                <form action="#" method="post" id="messages__list__element__delete">
                    <input type="hidden" name="delete_id_message" value="<?php echo $values["id"]; ?>">
                    <input type="image" id="messages__list__element__delete__image" src="img/delete.png" alt="delete">
                </form>
            <?php }
            } ?>
                <p id="messages__list__element__name">
                    <?php echo htmlspecialchars(getName($values["idauteur"])); ?>
                </p>
            </div>
        <?php } ?>
        </div>
        <?php if (count($messages) >= $load) { ?>
        <form action="#" method="post" id="messages__more_sub">
            <input type="hidden" name="load" value="<?php echo $load; ?>">
            <input type="submit" value="Voir plus">
        </form>
        <?php } else if(count($messages) == 0) { ?>
        <p id="messages__no_messages">
            Il n'y a pas de message dans ce sujet.
        </p>
        <?php }
        if ($connected) { ?>
        <div id="messages__new_message">
            <form action='#' method="post" id="messages__new_message__form">
                <textarea name="write_message" placeholder="Ecrire un message" id="messages__new_message__form__message"></textarea>
                <input type='submit' name="send_message" value="Poster" id="messages__new_message__form__submit">
            </form>
        </div>
        <?php } ?>
    </section>
</body>
</html>
