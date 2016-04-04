<?php

require "vendor/autoload.php";

//A library I borrowed from a friend for connection
$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $_POST['databasetype'],
        'user' => $_POST['username'],
        'dbname' => $_POST['databasename'],
        'host'=> $_POST['host'],
        'password'=> $_POST['password']
    )
);

$result = $atiaa->query("SELECT {$_POST['cols']} FROM {$_POST['tablename']}");
echo json_encode($result);
