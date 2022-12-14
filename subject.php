<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include_once "app/database.php";
$connected = False;
$rights = False;
$conseiller = False;

if (isset($_POST["load"])) {
    $load = $_POST["load"]+50;
    header("Location: subject.php");
    exit();
}

$load = 50;

if (isset($_SESSION["login"])) {
    $connected = True;
    if (getPermission($_SESSION['login'])[0] == "Moderateur" || getPermission($_SESSION['login'])[0] == 'Administrateur') {
        $rights = True;
    }
}

if (isset($_POST["delete_id_message"])) {
    $idmsg = $_POST["delete_id_message"];
    $idauteur = getAuteur($idmsg)[0][0];
    if ( $idauteur == $_SESSION["login"] || $rights) {
        deleteMessage($idmsg);
    }
}

if (isset($_POST["write_message"])) {
    addMessages($_SESSION['login'], $_GET['id'], $_POST["write_message"]);
}

$titre = htmlspecialchars(getTitle($_GET['id'])[0]["titre"]);
$messages = getMessages($_GET['id'], $load);
?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale=1.0>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
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
        <div id="messages__list">
            <?php foreach($messages as $values){ ?>
                <div id="messages__list__element">
                    <p id="messages__list__element__message">
                        <?php echo htmlspecialchars($values["contenu"]); ?>
                    </p>
                    <p id="subjects__list__element__name">
                        <?php echo htmlspecialchars(getName($values["idauteur"])); ?>
                    </p>
                <?php if ($connected) { 
                if($_SESSION['login'] == $values["idauteur"] || $rights) { ?>
                    <form action="#" method="post" id="messages__list__element__delete">
                        <input type="hidden" name="delete_id_message" value="<?php echo $values["id"] ?>">
                        <input type="image" id="messages__list__element__delete__image" src="img/delete.png" alt="delete">
                    </form>
                    <?php } ?>
                </div>  
            <?php } 
            }?>
            </div>
            <form action="#" method="post" id="messages__more_sub">
                <input type="hidden" name="load" value="<?php echo $load; ?>">
                <input type="submit" value="Voir plus">
            </form>
        <?php if ($connected) { ?>
        <div id = messages__add> 
            <form action='#' method="post" id="messages__formu">
                <input type="textbox" name="write_message" placeholder="Ecrire un message">
                <input type='submit' name="send_message" value="Envoyez">
            </form>
        </div>
        <?php } ?>
    </section>
</body>
</html>
