<?php

require "vendor/autoload.php";

$databasename = $_POST['databasename'];
$tablename = $_POST['tablename'];
$portnumber = $_POST['portnumber'];
$username = $_POST['username'];
$password = $_POST['password'];
$localhost = $_POST['localhost'];
$virtualhost = $_POST['virtualhost'];

class ImportTable extends \ajumamoro\Job
{
    private $tablename;
    private $databasename;

    public function ImportTable()
    {
        file_put_contents("ImportTable.sh", "ssh cloudera@{$_POST['virtualhost']} \"sqoop export --connect 
            'jdbc:{$_POST['databasetype']}://{$_POST['localhost']}:{$_POST['portnumber']}/{$_POST['databasename']}' --username={$_POST['username']} 
            -P={$_POST['password']} --table {$_POST['tablename']}  -m 1 &> ImportTable.out");
    }


    public function go()
    {
        $command = "ssh cloudera@{$this->getAttribute('virtualhost')} " .
             "\"sqoop export --connect 'jdbc:{$this->getAttribute('databasetype')}://{$this->getAttribute('localhost')}:{$this->getAttribute('portnumber')}/{$this->getAttribute('databasename')}' " .
             "--username={$this->getAttribute('username')} --password={$this->getAttribute('password')} --warehouse-dir=/user/hive/warehouse " .
             "--table {$this->getAttribute('tablename')}  -m 1 \" " .
             "&> importTable.out";

             file_put_contents("importTable.sh", $command);
           
        $this->log("Executing Job: $command");
        exec("bash ImportTable.sh ");
    }
}




 
       

