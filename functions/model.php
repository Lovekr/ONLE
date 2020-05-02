<?php

function clean_user_input($value){
    return strip_tags(htmlentities(trim($value)), ENT_NOQUOTES);
}

function fetch_current_session_data($db_con, $sessionid){
    $yr         =   date('Y')-1;
    $table_name =   'sessions';

	if($sessionid != "") {
		$sql        =   'SELECT * FROM '.DB_PREFIX.$table_name.' WHERE id=:id';
		$stmt1      =   $db_con->prepare($sql);
		$status     =   $stmt1->execute( array(":id" => $sessionid) );
	} else {
		$sql        =   'SELECT * FROM '.DB_PREFIX.$table_name.' WHERE year_start=:year_start';
		$stmt1      =   $db_con->prepare($sql);
		$status     =   $stmt1->execute( array(":year_start" => $yr) );
	}
    $result     =   $stmt1->fetch();
    return $result;
}

function kittocrypt( $string, $action) {
    $secret_key = '123456';
    $secret_iv = 'm123456iv';
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
    return $output;
}

function check_user_logged_in(){
    if(isset($_SESSION["user_token"]) OR isset($_COOKIE["user_token"]) ) {
        return "";
    }
    else{
        $redirect_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $url = "index.php?continue=".$redirect_url;
        destroy_session($url);
    }
}

function connect_database(){
    try{
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET.'';
            $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
            ];
            $connection = new PDO($dsn,DB_USER,DB_PASSWORD,$opt);
            //PDOStatement->debugDumpParams();
            return $connection;
    }
    catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
}

function get_all_data($db_connection, $table_name, $order="DESC"){
    $sql1       = 'SELECT * FROM '.DB_PREFIX.$table_name.' ORDER BY id '.$order;
    $stmt1      = $db_connection->prepare($sql1);
    $status     = $stmt1->execute();
    $result1    = $stmt1->fetchAll();
    return $result1;
}



function get_all_data_sort($db_connection, $table_name, $order_name, $order){
    $sql1       = 'SELECT * FROM '.DB_PREFIX.$table_name.' ORDER BY '.$order_name." ".$order;
    $stmt1      = $db_connection->prepare($sql1);
    $status     = $stmt1->execute();
    $result1    = $stmt1->fetchAll();
    return $result1;
}

function get_row_data($db_connection, $table_name, $col_name, $col_value, $order="DESC"){
    //$sql1       =   'SELECT * FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.' = "'.$col_value.'" ORDER BY id '.$order;
    $sql1       =   'SELECT * FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.'=:col_value ORDER BY id '.$order;
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute( array(":col_value" => $col_value) );
    $result1    =   $stmt1->fetchAll();
    return $result1;
}

function get_row_data_by_order($db_connection, $table_name, $col_name, $col_value, $order_col="id", $order="DESC"){
    //$sql1       =   'SELECT * FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.' = "'.$col_value.'" ORDER BY  '.$order_col.' '.$order;
    //$sql1       =   'SELECT * FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.'=:col_value ORDER BY  '.$order_col.' '.$order;

    if($table_name == "pages") {
        $sql1       =   'SELECT * FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.'=:col_value AND web_enabled=1 ORDER BY  '.$order_col.' '.$order;
    } else {
        $sql1       =   'SELECT * FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.'=:col_value ORDER BY  '.$order_col.' '.$order;
    }
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute( array(":col_value" => $col_value) );
    $result1    =   $stmt1->fetchAll();
    return $result1;
}

function get_row_col($db_connection, $table_name, $column, $col_name, $col_value){
    //$sql1       =   'SELECT '.$column. ' FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.' = "'.$col_value.'" ';
    $sql1       =   'SELECT '.$column. ' FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.'=:col_value ';
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute( array(":col_value" => $col_value) );
    $result1    =   $stmt1->fetchColumn();
    return $result1;
}

function get_row_col_order($db_connection, $table_name, $column, $col_name, $col_value, $order_col="id", $order="DESC"){
    //$sql1       =   'SELECT '.$column. ' FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.' = "'.$col_value.'" ORDER BY  '.$order_col.' '.$order;
    $sql1       =   'SELECT '.$column. ' FROM '.DB_PREFIX.$table_name. ' WHERE '.$col_name.'=:col_value ORDER BY  '.$order_col.' '.$order;
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute( array(":col_value" => $col_value) );
    $result1    =   $stmt1->fetchColumn();
    return $result1;
}

function count_users($db_connection){
    $sql1       =   'SELECT * FROM '.DB_PREFIX.'users';
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute();
    $result1    =   $stmt1->rowCount();
    return $result1;
}


function get_last_id($db_connection, $table){
    $sql1       =   'SELECT MAX(receipt) as last_id FROM '.DB_PREFIX.$table;
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute();
    $result1    =   $stmt1->fetchColumn();
    if($result1 == ""){
      return "1";
    }else{
      return $result1;
    }
}

function get_max_length($db_connection, $table){
    $sql1       =  'SHOW COLUMNS FROM '.DB_PREFIX.$table;
    $stmt1      =   $db_connection->prepare($sql1);
    $status     =   $stmt1->execute();
    $result1    =   $stmt1->fetchAll();
    return $result1;
}


function get_input_max_length($db_con, $column, $table){
    $maxlength_int      =   "";
    $column_max_length  =   get_max_length($db_con, $table);
    foreach ($column_max_length as $key => $maxlength) {
        $col_type = preg_replace('/[0-9()]/','',$maxlength["Type"]);
        if($maxlength["Field"] == "$column" AND ($col_type == "VARCHAR" OR $col_type == "varchar") ) {
            $maxlength_int =  intval(preg_replace('/[^0-9]+/', '', $maxlength["Type"]), 10);
        }
    }
    return $maxlength_int;
}

function get_date_format($value){
    $dob = strtotime($value);
    return date( 'd-M-Y', $dob);
}

function get_date_org_format($value){
    $dob = strtotime($value);
    return date( 'Y-m-d', $dob);
}

function format_int_value($value){
      return @number_format($value, 2);
}

function get_last_day_month($start_date){
    return date('t',strtotime("$start_date"));
}

function destroy_session($url){
    session_unset();
    session_destroy(); 
    $domain     =   ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
    $expire     =   time()-(3600 * 24); // 24 hours back - Reset Cookie
    setcookie("user_id",    "", $expire, "/", $domain, false);
    setcookie("user_token", "", $expire, "/", $domain, false);
    setcookie("user_name",  "", $expire, "/", $domain, false);
    if(trim($url) != ""){
         header("Location: $url");
    }else{
        header('Location: index.php'); /*K2 THIS IS FAIL SAFE*/
    }
    exit();
}



function get_all_data_cl2($db_connection, $table_name, $session_id){
$sql1       = 'SELECT * FROM '.DB_PREFIX.$table_name.' WHERE id = :session ';
$stmt1      = $db_connection->prepare($sql1);
$stmt1->bindValue(":session",   $session_id,  PDO::PARAM_INT);
$status     = $stmt1->execute();
$result1    = $stmt1->fetchAll();
return $result1;
}

    



function run_query($db_connection, $table_name, $query){
    $sql1       = 'SELECT * FROM '.DB_PREFIX.$table_name.$query;
    //echo $sql1;
    $stmt1      = $db_connection->prepare($sql1);
    $status     = $stmt1->execute();
    $result1    = $stmt1->fetchAll();
    $stmt1->closeCursor();
    return $result1;
}

function run_query2($db_connection, $column, $table_name, $query){
    $sql1       = 'SELECT '.$column.' FROM '.DB_PREFIX.$table_name.$query;
    $stmt1      = $db_connection->prepare($sql1);
    $status     = $stmt1->execute();
    $result1    = $stmt1->fetchAll();
    $stmt1->closeCursor();
    return $result1;
}





/*ADDED BY KITTO ENDS*/
function find($db_connection, $type, $table, $value='*', $where_clause, $execute=array())
{
    $db = $db_connection;
    if($where_clause)
    {
        $sql = "SELECT ".$value." FROM ".$table." ".$where_clause."";
    }
    else
    {
        $sql = "SELECT ".$value." FROM ".$table;
    }
    //echo $sql;
    // print_r($execute);
    $last_query = $sql;
    $prepare_sql = $db->prepare($sql);
    $prepare_sql->execute($execute);
    if($prepare_sql->errorCode() == 0) {
        if($type == 'first')
        {
            //fetch single record from database
            $result = $prepare_sql->fetch(PDO::FETCH_ASSOC);
            //$result = $prepare_sql->fetch();
        }
        else if($type == 'all')
        {
            //fetch multiple record from database
            $result = $prepare_sql->fetchAll(PDO::FETCH_ASSOC);
            //$result = $prepare_sql->fetchAll();
        }
        return $result;
    } else {
        /*$errors = $prepare_sql->errorInfo();
        echo '<pre>';
        print_r($errors[2]);
        echo '</pre>';
        die();*/
    }
}
function save($db_connection,$table, $fields, $values, $execute)
{
    $db = $db_connection;
    $result = false;
    $sql = "INSERT INTO ".$table." (".$fields.") VALUES (".$values.")";
    $last_query = $sql;
    $prepare_sql = $db->prepare($sql);
    $prepare_sql->execute($execute);

    $errors = $prepare_sql->errorInfo();
    //   echo $sql;
//  echo '<pre>';
//  print_r($errors[2]);
//  echo '</pre>';
    $result = $db->lastInsertId();
    return $result;
}
function update($db_connection,$table, $set_value, $where_clause, $execute)
{
    $db = $db_connection;
    $sql = "UPDATE ".$table." SET ".$set_value." ".$where_clause."";
    //echo $sql;
    $last_query = $sql;
    $prepare_sql = $db->prepare($sql);
    if($prepare_sql->errorCode() == 0) {
        $prepare_sql->execute($execute);
        $errors = $prepare_sql->errorInfo();
        /*echo '<pre>';
        print_r($errors[2]);
        echo '</pre>';*/
        return true;
    } else {
        $errors = $prepare_sql->errorInfo();
        /*echo '<pre>';
        print_r($errors[2]);
        echo '</pre>';
        die();*/
        return false;
    }
}
function delete($db_connection,$table, $where_clause, $execute=array())
{
    $db = $db_connection;

    $sql = "DELETE FROM ".$table." ".$where_clause."";
    $last_query = $sql;
    $prepare_sql = $db->prepare($sql);
    $prepare_sql->execute($execute);

    return true;
}
function countGalleryImage($db_con,$galleryId){
    $totalImages = 0;
    $whereReport = "where gallery_id = '".$galleryId."'";
    $gallery_images = find($db_con,'all', DB_PREFIX.'gallery_images', '*', $whereReport, $execute=array());
    if($gallery_images){
        //print_r($event_images);
        $totalImages =  count($gallery_images);
    }
    return $totalImages;
}


?>
