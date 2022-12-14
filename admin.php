<!DOCTYPE html>
<?php
session_start();

include_once "app/database.php";
$database = new Database();
$rights = false;
$connected = false;
$permission = "utilisateur";

if (isset($_POST["delete_id_user"])) {
    if ($_POST["delete_id_user"] == $_SESSION["login"]) {
        header("Location: admin.php");
        exit();
    }
    $database->deleteUser($_POST["delete_id_user"]);
    header("Location: admin.php");
    exit();
}

if (isset($_SESSION["login"])) {
    $permission = $database->getPermission($_SESSION["login"]);
    if ($permission == "administrateur" || $permission == "moderateur") {
        $connected = true;
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

if ($permission == "administrateur") {
    if (isset($_POST["admin_permission"]) && isset($_POST["admin_id"])) {
        $database->changePermission($_POST["admin_id"], $_POST["admin_permission"]);
        header("Location: admin.php");
        exit();
    } else if (isset($_POST["modo_permission"]) || isset($_POST["modo_id"])) {
        $database->changePermission($_POST["modo_id"],$_POST["modo_permission"]);
        header("Location: admin.php");
        exit();
    } else if (isset($_POST["conseiller_permission"]) || isset($_POST["conseiller_id"])) {
        $database->changePermission($_POST["conseiller_id"],$_POST["conseiller_permission"]);
        header("Location: admin.php");
        exit();
    } else if (isset($_POST["utilisateur_permission"]) || isset($_POST["utilisateur_id"])) {
        $database->changePermission($_POST["utilisateur_id"],$_POST["utilisateur_permission"]);
        header("Location: admin.php");
        exit();
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
    <title>Administration - Forumone</title>
</head>
<body>
    <header id="header">
        <div id="header__head">
            <img src="img/forumone.png" alt="icon" id="header__head__image">
            <div id="header__head__title">
                <h1 id="header__head__title__title">Forumone</h1>
                <p id="header__head__title__sub_title">Forum de conseil en s??duction</p>
            </div>
        </div>
    </header>
    <section id="users__head">
        <a href="index.php" id="users__head__home">
            Retour ?? l'accueil
        </a>
        <div id="users__head__content">
            <div id="users__head__content__infos">
                <p id="users__head__content__infos__pseudo">
                    Pseudo de l'utilisateur
                </p>
                <p id="users__head__content__infos__permission">
                    Permission de l'utilisateur
                </p>
            </div>
            <div id="users__head__content__actions">
                <p id="users__head__actions__content__permission">
                    Changer ses permissions
                </p>
            </div>
        </div>
    </section>
    <section id="users__list">
        <?php foreach($database->allUsers() as $values) { ?>
            <div id="users__list__element">
                <div id="users__list__element__infos">
                    <p id="users__list__element__infos__pseudo">
                        <?php echo htmlspecialchars($values["pseudo"]); ?>
                    </p>
                    <div id="users__list__element__infos__permission">
                        <?php
                        echo htmlspecialchars($database->getPermission($database->getId($values["pseudo"])));
                        $userId = $database->getId($values["pseudo"]);
                         ?>
                    </div>
                </div>
            <div id="users__list__forms">
                <?php if ($permission == "administrateur" && $connected) { ?>
                <form action="#" method="post" id="users__list__forms__administrateur">
                    <input type="hidden" name="admin_permission" value="administrateur">
                    <input type="hidden" name="admin_id" value="<?php echo $userId; ?>">
                    <input type="submit" id="users__list__admin" value="Administrateur">
                </form>
                <form action="#" method="post" id="users__list__forms__moderateur">
                    <input type="hidden" name="modo_permission" value="moderateur">
                    <input type="hidden" name="modo_id" value="<?php echo $userId; ?>">
                    <input type="submit" id="users__list__modo" value="Mod??rateur">
                </form>
                <?php } ?>
                <form action="#" method="post" id="users__list__forms__conseiller">
                    <input type="hidden" name="conseiller_permission" value="conseiller">
                    <input type="hidden" name="conseiller_id" value="<?php echo $userId; ?>">
                    <input type="submit" id="users__list__conseiller" value="Conseiller">
                </form>
                <form action="#" method="post" id="users__list__forms__utilisateur">
                    <input type="hidden" name="utilisateur_permission" value="utilisateur">
                    <input type="hidden" name="utilisateur_id" value="<?php echo $userId; ?>">
                    <input type="submit" id="users__list__utilisateur" value="Utilisateur">
                </form>
                <?php if (($permission == "administrateur" || $permission == "moderateur") && $connected) { ?>
                <form action="#" method="post" id="users__list__forms__delete">
                    <input type="hidden" name="delete_id_user" value="<?php echo $userId; ?>">
                    <input type="image" id="users__list__forms__delete__image" src="img/delete.png" alt="delete">
                </form>
                <?php } ?>
                </div>
            </div>
            <?php } ?>
    </section>
</body>
</html>
