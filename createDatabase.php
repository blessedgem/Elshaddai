<?php
//
//require "vendor/autoload.php";
//
//$username =$_POST['username'];
//$database =$_POST['databasename'];
//$password =$_POST['password'];
//$host=$_POST['host'];
//$tablename=$_POST['tablename'];
//$temp = $_POST['databasetype'];
//
////A library I borrowed from a friend for connection
//$atiaa = \ntentan\atiaa\Driver::getConnection(
//    array(
//        'driver' => $temp,
//        'user' => $username,
//        'dbname' => $database,
//        'host'=> $host,
//        'password'=>$password
//    )
//);
////Make the query
//
//$createDatabase = $atiaa->query("Create database $database");
//$createTable = $atiaa->query("Create table $tablename");

$connection = ssh2_connect('10.76.254.127', 22);

if(ssh2_auth_password($connection, 'cloudera', 'cloudera'))
{
//    echo 'connected';
    $stream = ssh2_exec($connection, "hive -e 'describe account_transactions'");
    stream_set_blocking($stream, true);
    $output = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
    $trim = explode("WARN", stream_get_contents($output));
    $str = explode("\n", $trim[0]);
    
    foreach ($str as $value)
    {
        if(!$value) continue;
        
        $fields = explode("\t", $value);
        $columnNames[] = $fields[0];
        $dataTypes[] = $fields[1];
    }
    
    
    
    echo json_encode($dataTypes);
    
            
    //echo stream_get_contents($stream);//json_encode($stream);
}


?>