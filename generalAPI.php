<?php

require "vendor/autoload.php";

$username =$_POST['username'];
$database =$_POST['databasename'];
$password =$_POST['password'];
$host=$_POST['host'];
$tablename=$_POST['tablename'];
$temp = $_POST['databasetype'];

//A library I borrowed from a friend for connection
$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $temp,
        'user' => $username,
        'dbname' => $database,
        'host'=> $host,
        'password'=>$password
    )
);
    //Make the query
    $data = $atiaa->query("SELECT * FROM $tablename limit 100");
    $columnType = $atiaa->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$tablename'");
     
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 25;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
    
    $columns = array();
    //$eliminatedFields = array("user_id","bank_name","description");
    
    $col="#F1F1F1";

    $columns = array();
    foreach($columnType as $key) {
        $columns[] = ucwords(str_replace("_", " ", $key['column_name']));
        $dataTypes[] = $key['data_type'];
    }
