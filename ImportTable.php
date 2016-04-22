<?php

require "vendor/autoload.php";


$databasename =$_POST['databasename'];
$tablename =$_POST['tablename'];







class ImportTable extends \ajumamoro\Job
{
    private $tablename;
    private $databasename;

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