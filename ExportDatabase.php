<?php

require "vendor/autoload.php";

$username =$_POST['username'];
$databasename =$_POST['databasename'];
$password =$_POST['password'];
$localhost=$_POST['localhost'];
$virtualhost=$_POST['virtualhost'];
$drivername = $_POST['databasetype'];
$portnumber = $_POST['portnumber'];
$dirname = $_POST['dirname'];

class ExportDatabase extends \ajumamoro\Job
{
    private $virtualhost;
    private $localhost;
    private $dirname;
    private $username;
    private $databasename;
    private $password;
    private $drivername;
    private $dbport;

    public function ExportDatabase()
    {
        file_put_contents("exportDatabase.sh", "ssh cloudera@${$_POST['virtualhost']} \"sqoop import-all-tables 
        	--connect 'jdbc:{$_POST['databasetype']}://{$_POST['localhost']}:{$_POST['portnumber']}/{$_POST['databasename']}' 
        	--username={$_POST['username']} -P={$_POST['password']} -m 1 --warehouse-dir=/user/hive/warehouse --hive-import'
        	 &> test.out");
    }


    public function go()
    {

        $command = "ssh cloudera@{$this->getAttribute('virtualhost')} " .
             "\"sqoop import-all-tables --connect 'jdbc:{$this->getAttribute('databasetype')}://{$this->getAttribute('localhost')}:{$this->getAttribute('portnumber')}/{$this->getAttribute('databasename')}' " .
             "--username={$this->getAttribute('username')} --password={$this->getAttribute('password')} --warehouse-dir=/user/hive/warehouse " .
             " --hive-import -m 1 \" " .
             "&> test.out";


         file_put_contents("exportDatabase.sh", $command);        
            
        $this->log("Executing Job: $command");
        exec("bash exportDatabase.sh ");
    }
}


   

