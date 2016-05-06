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
        file_put_contents("ImportTable.sh", "ssh cloudera@$virtualhost 'sqoop export --connect 'jdbc:$databasetype://$localhost:$portnumber/$databasename' --username=$username -P=$password -m 1' &> ImportTable.out");
    }


    public function go()
    {
        file_put_contents("ImportTable.sh", "ssh cloudera@{$this->getAttribute('virtualhost')} 'sqoop import-all-tables --connect 'jdbc:{$this->getAttribute('databasetype')}://{$this->getAttribute('localhost')}:{$this->getAttribute('portnumber')}/{$this->getAttribute('databasename')}' --username={$this->getAttribute('username')} --password={$this->getAttribute('password')} ' &> ImportTable.out");
            
        $this->log("Executing Job");
        exec("bash ImportTable.sh ");
    }
}