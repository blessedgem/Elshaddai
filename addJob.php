<?php
require "vendor/autoload.php";
require "ExportDatabase.php";
//require "ImportTable.php";
require 'database.php';

if($_POST['graph'])
{
    $reponse = Database::query($_REQUEST, $_POST);
//    $job = new ImportTable();
    
    $atiaa = \ntentan\atiaa\Driver::getConnection(
        array(
            'driver' => 'postgresql',
            'dbname' => 'dummy',
            'password'=> $post['password'],
            'user' => $post['username'],
            'host'=> $post['host']
        )
    );
    $atiaa->query("CREATE table dummy_table");
    
    foreach ($reponse['result'] as $data)
    {
        $value = 0;
        $counter = 0;
        foreach ($data as $value)
        {
            $values = $counter == '0' ? "" : $values . ", ";
            $values .= $value;
            $counter ++;
        }
        
        echo json_encode($values);die();
        $atiaa->query("CREATE table dummy_table");
        $atiaa->query("INSERT INTO table_name ({$_POST['cols']}) VALUES ($values);");
    }
}

else
{
    $data = require "ajumamoro.conf.php";
    $job = new ExportDatabase();
}

$queue = ajumamoro\Queue::connectBroker([
    'driver' => 'redis',
    'scheme' => 'tcp',
    'host' => '127.0.0.1'
]);

$job->addAttribute('username', $_POST['username']);
$job->addAttribute('databasename',$_POST['databasename']);
$job->addAttribute('password',$_POST['password']);
$job->addAttribute('localhost',$_POST['localhost']);
$job->addAttribute('virtualhost',$_POST['virtualhost']);
$job->addAttribute('databasetype',$_POST['databasetype']);
$job->addAttribute('portnumber',$_POST['portnumber']);
$job->addAttribute('dirname',$_POST['dirname']);
$queue->add($job);


