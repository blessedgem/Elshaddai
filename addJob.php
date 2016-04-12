<?php


require "vendor/autoload.php";
require "ExportDatabase.php";
var_dump($_POST);
$data = require "ajumamoro.conf.php";;
$queue = ajumamoro\Queue::connectBroker([
    'driver' => 'redis',
    'scheme' => 'tcp',
    'host' => '127.0.0.1'
]);
var_dump($data);
$scheduler = \ajumamoro\Scheduler::connect($data['store']);
//$queue->add(new ExportJob());
//$scheduler->add(new ImportJob());
$queue->add(new ExportDatabase());