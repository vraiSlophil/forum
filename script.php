<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
include_once "app/database.php";

if (isset($_GET['idmsg'])) {
    $idmsg = $_GET['idmsg'];
    modifyLikes($idmsg, getAuteur($idmsg));
}
?>
