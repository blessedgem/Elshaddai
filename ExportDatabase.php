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
        file_put_contents("exportDatabase.sh", "ssh cloudera@$virtualhost 'sqoop import-all-tables --connect 'jdbc:$databasetype://$localhost:$portnumber/$databasename' --username=$username -P=$password -m 1' &> exportDatabse.out");
    }


    public function go()
    {
        file_put_contents("exportDatabase.sh", "ssh cloudera@{$this->getAttribute('virtualhost')} 'sqoop import-all-tables --connect 'jdbc:{$this->getAttribute('databasetype')}://{$this->getAttribute('localhost')}:{$this->getAttribute('portnumber')}/{$this->getAttribute('databasename')}' --username={$this->getAttribute('username')} --password={$this->getAttribute('password')} ' &> exportDatabse.out");
            
        $this->log("Executing Job");
        exec("bash exportDatabase.sh ");
    }
}