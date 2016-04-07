<?php

require "vendor/autoload.php";

$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $_POST['databasetype'],
        'dbname' => $_POST['databasename'],
        'password'=> $_POST['password'],
        'user' => $_POST['username'],
        'host'=> $_POST['host'],
    )
);

$columns = $_POST['cols'] ? $_POST['cols'] : "*";
$conditions = $_POST['where'] ? " where " . $_POST['where'] : "";
$result = $atiaa->query("SELECT $columns FROM {$_POST['tablename']} $conditions limit 100");
echo json_encode($result);
