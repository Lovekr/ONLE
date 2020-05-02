<?php
require_once("../config.php");
require_once("../functions/model.php");
$db_con = connect_database();
$username = trim($_REQUEST["username"]);
if($username == ""){
    $rowCount = 0;
}
else{
    $statement = $db_con->prepare("SELECT * FROM ".DB_PREFIX."admin WHERE username = ?");
    $statement->execute(array($username) );
    $rows = $statement->fetchAll();
    $total_rows = count($rows);
}
if($total_rows >0){
    echo 'false';
}
else{
       echo 'true';
}
?>