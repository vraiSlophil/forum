<!DOCTYPE html>

<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include_once "app/database.php";

$rights = True;

if (isset($_SESSION['login'])) {
    if (getPermission($_SESSION['login']) == 'Administrateur' || getPermission($_SESSION['login']) == 'Moderateur') {
        exit();
    } else {
        $rights = False;
    }
}

if (isset($_POST["admin_permission"])) {
    if (isset($_POST["admin_id"])) {

    }
}

if (isset($_POST["modo_permission"])) {
    if (isset($_POST["modo_id"])) {
        
    }
}

if (isset($_POST["conseiller_permission"])) {
    if (isset($_POST["conseiller_id"])) {
        changePermission($_POST["conseiller_id"],"conseiller");
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
    <title>Forumone - Administration</title>
</head>
<body>
    <header id="header">
        <div id="header__head">
            <img src="img/forumone.png" alt="icon" id="header__head__image">
            <div id="header__head__title">
                <h1 id="header__head__title__title">Forumone - Administration </h1>
                <p id="header__head__title__sub_title">Forum de conseil en séduction</p>
            </div>
            <h2 id="header__head__role"> <?php echo getPermission($_SESSION['login'])[0]['permission']; ?> </h2> 
        </div>
    </header>
    <section id="list_users">

        <?php 
            foreach(allUsers() as $values) { ?>
            <div id="list_users__list_pseudo">
                <?php echo htmlspecialchars($values["pseudo"]); ?>
                <div>
                    <?php 
                    
                    echo htmlspecialchars(getPermission(getId($values["pseudo"])[0]["id"])[0]["permission"]);
                    $userId = getId($values["pseudo"])[0]["id"];
                    // print_r(getId($values["pseudo"])[0]["id"]);
                    // print_r(getPermission(getId($values["pseudo"])[0]["id"])[0]["permission"]);
                     ?>
                </div>
            
            <div id="list_users__button">
                <form action="#" method="post">
                    <input type="hidden" name="admin_permission" value="admin">
                    <input type="hidden" name="admin_id" value="<?php echo $userId; ?>">
                    <input type="submit" id="list_users__admin" value="Administrateur">
                </form>
                <form action="#" method="post">
                    <input type="hidden" name="modo_permission" value="modo">
                    <input type="hidden" name="modo_id"value="<?php echo $userId; ?>">
                    <input type="submit" id="list_users__modo" value="Modérateur">
                </form>
                <form action="#" method="post">
                    <input type="hidden" name="conseiller_permission" value="conseiller">
                    <input type="hidden" name="conseiller_id" value="<?php echo $userId; ?>">
                    <input type="submit" id="list_users__conseiller" value="Conseiller">
                </form>
                </div>
            </div>
            <?php } ?>
        
        
    </section>
</body>

</html>

