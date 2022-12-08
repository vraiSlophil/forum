<?php 
function sql_connect() {
    $dbname = 'forum_no_mb_nl';
    $identifiant = 'root';
    $motdepasse = 'Yejequ@4';
    $port = 3306;
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
    return $statement->fetchAll();
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
    while ($row = $statement->fetch()) {
        return $row[0];
    }
}

function createSubject($sbjct_name, $id) {
    $database = sql_connect();
    $sql = "INSERT INTO 'sujets'(idauteur, titre, date) VALUES (:id, :titre, NOW());";
    $statement = $database->prepare($sql);
    $statement->bindParam(':id', $id);
    $statement->bindParam(':titre', $sbjct_name);
    $statement->execute();
    $statement->closeCursor();
} 

function createUser($pseudo, $password){
    $database = sql_connect();
    $sql = "INSERT INTO `clients` (pseudo, password, date, permission) VALUES (:pseudo, :password, NOW(), :permission);";
    $statement = $database->prepare($sql);
    $statement->bindParam(':pseudo', $pseudo);
    $md5 = md5($password);
    $statement->bindParam(':password', $md5);
    $str = "user";
    $statement->bindParam(':permission', $str);
    $statement->execute();
    $statement->closeCursor();
}

function getSubjects($limit) {
    global $database;
    $sql = "SELECT * FROM `sujets` ORDER BY date DESC LIMIT :limit;";
    $statement = $database->prepare($sql);
    $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
    $statement->execute();
    $rows = $statement->fetchAll();
    return $rows;
}

function checkLogin($pseudo, $password){
    $database = sql_connect();
    $sql = "SELECT password FROM clients WHERE pseudo = :p;";
    $inter_check = $database->prepare($sql);
    $inter_check->bindParam(":p",$pseudo);
    // $inter_check->bindParam(":mdp",$password);
    $inter_check->execute();
    $check = $inter_check->fetchAll();
    if ($check == md5($password)){
        return getId($pseudo);
    } else {
        return 0;
    }

}

?>