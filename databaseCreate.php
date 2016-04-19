<?php
// Command line instructions for creating database
// 
require "vendor/autoload.php";


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
 
$Database = $atiaa->query("CREATE DATABASE $database" );

// sql to create table
$table = $atiaa->("CREATE TABLE $tablename (

)";



?>