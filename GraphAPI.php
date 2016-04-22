<?php
require "vendor/autoload.php";
//A library I borrowed from a friend for connection
$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => 'postgresql',
        'user' => 'postgres',
        'dbname' => 'gemsoft',
        'host'=> 'localhost',
        'password'=>'12345'
    )
);
$data = $atiaa->query("SELECT transaction_id, amount FROM account_transactions limit 100");

echo json_encode($data);