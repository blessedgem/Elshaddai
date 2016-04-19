<?php
require "vendor/autoload.php";
require "ExportDatabase.php";

$data = require "ajumamoro.conf.php";

$username =$_POST['username'];
$databasename =$_POST['databasename'];
$password =$_POST['password'];
$localhost=$_POST['localhost'];
$virtualhost=$_POST['virtualhost'];
$drivername = $_POST['databasetype'];
$dbport = $_POST['portnumber'];
$dirname = $_POST['dirname'];

$queue = ajumamoro\Queue::connectBroker([
    'driver' => 'redis',
    'scheme' => 'tcp',
    'host' => '127.0.0.1'
]);
$job = new ExportDatabase();
$job->addAttribute('username', $_POST['username']);
$job->addAttribute('databasename',$_POST['databasename']);
$job->addAttribute('password',$_POST['password']);
$job->addAttribute('localhost',$_POST['localhost']);
$job->addAttribute('virtualhost',$_POST['virtualhost']);
$job->addAttribute('databasetype',$_POST['databasetype']);
$job->addAttribute('portnumber',$_POST['portnumber']);
$job->addAttribute('dirname',$_POST['dirname']);
$queue->add($job);


