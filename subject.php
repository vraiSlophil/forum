<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

include_once "app/database.php";

$titre = getSubjectName($_POST['id']);
$messages = getMessages($_POST['id']);

?>

<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width", initial-scale=1.0>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $titre?> - Forumone</title>
    </head>
<body>
    <section id="messages">

        <div id="messages__list">
            <?php print_r($messages); ?>

        </div>
    </section>
</body>
</html>
