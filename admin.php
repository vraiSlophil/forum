<!DOCTYPE html>
<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include_once "app/database.php";

$rights = false;
$connected = false;
$permission = "utilisateur";

if (isset($_POST["delete_id_user"])) {
    deleteUser($_POST["delete_id_user"]);
    header("Location: admin.php");
    exit();
}

if (isset($_SESSION["login"])) {
    $permission = getPermission($_SESSION["login"])[0]["permission"];
    if ($permission == "administrateur" || $permission == "moderateur") {
        $connected = true;
    } else {
        header("Location: index.php");
        exit();
    }
}

if ($permission == "administrateur" && $connected) {
    if (isset($_POST["admin_permission"]) && isset($_POST["admin_id"])) {
        changePermission($_POST["admin_id"], $_POST["admin_permission"]);
        header("Location: admin.php");
        exit();
    } else if (isset($_POST["modo_permission"]) || isset($_POST["modo_id"])) {
        changePermission($_POST["modo_id"],$_POST["modo_permission"]);
        header("Location: admin.php");
        exit();
    } else if (isset($_POST["conseiller_permission"]) || isset($_POST["conseiller_id"])) {
        changePermission($_POST["conseiller_id"],$_POST["conseiller_permission"]);
        header("Location: admin.php");
        exit();
    } else if (isset($_POST["utilisateur_permission"]) || isset($_POST["utilisateur_id"])) {
        changePermission($_POST["utilisateur_id"],$_POST["utilisateur_permission"]);
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
                <p id="header__head__title__sub_title">Forum de conseil en séduction</p>
            </div>
        </div>
        <a href="index.php" id="register_form__home">
            Retour à l'accueil
        </a>
    </header>
    <section id="users__list">
        <?php foreach(allUsers() as $values) { ?>
            <div id="users__list__element">
                <div id="users__list__element__infos">
                    <p id="users__list__element__infos__pseudo">
                        <?php echo htmlspecialchars($values["pseudo"]); ?>
                    </p>
                    <div id="users__list__element__infos__permission">
                        <?php
                        echo htmlspecialchars(getPermission(getId($values["pseudo"])[0]["id"])[0]["permission"]);
                        $userId = getId($values["pseudo"])[0]["id"];
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
                    <input type="submit" id="users__list__modo" value="Modérateur">
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
