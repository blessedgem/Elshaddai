<?php
require "vendor/autoload.php";
//A library I borrowed from a friend for connection
$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => 'postgresql',
        'user' => 'postgres',
        'dbname' => 'Project',
        'host'=> 'localhost',
        'password'=>'gem'
    )
);
$data = $atiaa->query("SELECT amount, transaction_date FROM account_transactions limit 100");

echo json_encode($data);
?>
