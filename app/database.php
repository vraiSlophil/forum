<?php 
function sql_connect() {
    $dbname = 'forum_no_mb_nl';
    $identifiant = 'root';
    $motdepasse = '';
    $port = 3307;
    try { 
        $sch='mysql:host=localhost;dbname='.$dbname.';port='.$port;
        $bdd = new PDO($sch , $identifiant, $motdepasse);
    }
    catch(Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
    return $bdd;
}

function getName($id) {
    $database = sql_connect();
    $sql = "SELECT pseudo FROM `clients` WHERE id=:id;";
    $statement = $database->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll()[0]["pseudo"];
}

function getPassword($id) {
    $database = sql_connect();
    $sql = "SELECT password FROM `clients` WHERE id=:id;";
    $statement = $database->prepare($sql);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function getId($pseudo) {
    $database = sql_connect();
    $sql = "SELECT id FROM `clients` WHERE pseudo=:pseudo;";
    $statement = $database->prepare($sql);
    $statement->bindValue(':pseudo', $pseudo);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function createSubject($sbjct_name, $id) {
    $database = sql_connect();
    $sql = "INSERT INTO sujets(idauteur, titre, date) VALUES (:id, :titre, NOW());";
    $statement = $database->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':titre', $sbjct_name);
    $statement->execute();
    $count = $statement->rowCount();
    if ($count != 1) {
        return 0;
    }
    return 1;
} 

function createUser($pseudo, $password) {
    $database = sql_connect();
    $sql = "INSERT INTO `clients` (pseudo, password, date, permission) VALUES (:pseudo, :password, NOW(), :permission);";
    $statement = $database->prepare($sql);
    $statement->bindParam(':pseudo', $pseudo);
    $md5 = md5($password);
    $statement->bindParam(':password', $md5);
    $str = "user";
    $statement->bindParam(':permission', $str);
    $statement->execute();
    return $statement->rowCount();
}

function getSubjects($limit) {
    $database = sql_connect();
    $sql = "SELECT * FROM `sujets` ORDER BY date DESC LIMIT :limit;";
    $statement = $database->prepare($sql);
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function checkLogin($pseudo, $password){
    $database = sql_connect();
    $sql = "SELECT password FROM clients WHERE pseudo = :p;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":p",$pseudo);
    $statement->execute();
    $count = $statement->rowCount();
    if ($count != 1) {
        return 0;
    }
    $check = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($check[0]["password"] == md5($password)){
        return getId($pseudo);
    } else {
        return 0;
    }
}

function getSubjectName($id) {
    $database = sql_connect();
    $sql = "SELECT titre FROM sujets WHERE id = :id;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":id", $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function getMessages($id, $limit) {
    $database = sql_connect();
    $sql = "SELECT id, idauteur, contenu FROM messages WHERE idsujet = :idsbjct ORDER BY id DESC LIMIT :limit;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":idsbjct", $id, PDO::PARAM_INT);
    $statement->bindParam(":limit", $limit, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function addMessages($idauteur, $idsujet, $contenu) {
    $database = sql_connect();
    $sql = "INSERT INTO messages (idauteur, idsujet, contenu) VALUES (:idauteur, :idsujet, :contenu);";
    $statement = $database->prepare($sql);
    $statement->bindParam(':idauteur', $idauteur, PDO::PARAM_INT);
    $statement->bindParam(':idsujet', $idsujet, PDO::PARAM_INT);
    $statement->bindParam(':contenu', $contenu);
    $statement->execute();
    return $statement->rowCount();

}

function deleteMessage($idmessage) {
    $database = sql_connect();
    $sql = "DELETE FROM messages WHERE id = :idmsg;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":idmsg", $idmessage, PDO::PARAM_INT);
    $statement->execute();
}

function deleteSubject($idsujet) {
    $database = sql_connect();
    $sql = "DELETE FROM sujets WHERE id = :idsujet; DELETE FROM messages WHERE idsujet = :idsujet;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":idsujet", $idsujet, PDO::PARAM_INT);
    $statement->execute();
}

function getAuteur($idmessage) {
    $database = sql_connect();
    $sql = "SELECT idauteur FROM messages WHERE id = :idmsg;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":idmsg", $idmessage, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function getSubjectAuteur($idsujet) {
    $database = sql_connect();
    $sql = "SELECT idauteur FROM sujets WHERE id = :idsujet;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":idsujet", $idsujet, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function getTitle($idsujet) {
    $database = sql_connect();
    $sql = "SELECT titre FROM sujets WHERE id = :idsjt;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":idsjt", $idsujet, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getPermission($iduser) {
    $database = sql_connect();
    $sql = "SELECT permission FROM clients WHERE id = :iduser;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":iduser", $iduser, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function allUsers() {
    $database = sql_connect();
    $sql = "SELECT pseudo FROM clients;";
    $statement = $database->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function changePermission($id,$permission) {
    $database = sql_connect();
    $sql = "UPDATE clients SET permission = :perm WHERE id = :identifiant;";
    $statement = $database->prepare($sql);
    $statement->bindParam(":perm", $permission, PDO::PARAM_INT);
    $statement->bindParam(":identifiant", $id, PDO::PARAM_INT);
    $statement->execute();
}
?>

