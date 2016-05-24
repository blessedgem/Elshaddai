<?php

require "vendor/autoload.php";
require "ImportTable.php";

$username = $_POST['username'];
$database = $_POST['databasename'];
$password = $_POST['password'];
$host = $_POST['host'];
$tablename = $_POST['tablename'];
$temp = $_POST['databasetype'];
$portnumber = $_POST['portnumber'];
$virtualhost = $_POST['virtualhost'];
$localhost = $_POST['localhost'];

//A library I borrowed from a friend for connection
$atiaa = \ntentan\atiaa\Driver::getConnection(
    array(
        'driver' => $temp,
        'user' => $username,
        'dbname' => $database,
        'host'=> $host,
        'password'=> $password
    )
);

$connection = ssh2_connect('10.76.254.127', 22);

if(ssh2_auth_password($connection, 'cloudera', 'cloudera'))
{
    $stream = ssh2_exec($connection, "hive -e 'describe $tablename'");
    stream_set_blocking($stream, true);
    $output = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
    $trim = explode("WARN", stream_get_contents($output));
    $str = explode("\n", $trim[0]);
    
    foreach ($str as $value)
    {
        if(!$value) continue;
        
        $fields = explode("\t", $value);
        $fields[1] = trim($fields[1]) == 'string' ? 'character varying' : $fields[1];
        $fields[1] = trim($fields[1]) == 'double' ? 'numeric' : $fields[1];
        $fields[1] = trim($fields[1]) == 'int' ? 'integer' : $fields[1];
        
        $columnData[] = trim($fields[0]) . " " . trim($fields[1]);
        $columnNames[] = trim($fields[0]);
        $dataTypes[] = trim($fields[1]);
    }
    
    $columns = implode(',', $columnData);
    $atiaa->query("create table $tablename ($columns)");
    
    $data = require "ajumamoro.conf.php";
    $job = new ImportTable();
    
    $queue = ajumamoro\Queue::connectBroker([
        'driver' => 'redis',
        'scheme' => 'tcp',
        'host' => '127.0.0.1'
    ]);
//
    $job->addAttribute('username', $_POST['username']);
    $job->addAttribute('databasename', $_POST['databasename']);
    $job->addAttribute('password',$_POST['password']);
    $job->addAttribute('localhost',$_POST['host']);
    $job->addAttribute('virtualhost','10.76.254.127');
    $job->addAttribute('databasetype',$_POST['databasetype']);
        
    $job->addAttribute('portnumber',$_POST['portnumber']);
    $job->addAttribute('dirname',$_POST['dirname']);
    
    $queue->add($job);
    
    echo 'It works';
}
else
{
    echo 'Connection Failed';
}

?>