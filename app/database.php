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
    return $bdd ;
}



function new_subject($_POST['nv_sujet']) {
    $databse = sql_connect();

} 

?>