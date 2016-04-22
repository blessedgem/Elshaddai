<?php

require "vendor/autoload.php";

$localhost=$_POST['localhost'];
$virtualhost=$_POST['virtualhost'];
$dirname = $_POST['dirname'];

class ExportTable extends \ajumamoro\Job
{
    private $virtualhost;
    private $localhost;
    private $dirname;

    public function ExportDatabase()
    {
        file_put_contents("exportTable.sh", "ssh cloudera@$virtualhost 'sqoop import --connect 'jdbc:postgresql://$localhost:5432/dummy' --username=postgres --password=gem --target-dir /$dirname --table dummy_table -m 1' &> exportTable.out");
    }


    public function go()
    {
        file_put_contents("exportTable.sh", "ssh cloudera@{$this->getAttribute('virtualhost')} 'sqoop import --connect 'jdbc:postgresql://{$this->getAttribute('localhost')}:5432/dummy --username=postgres --password=gem --target-dir /{$this->getAttribute('dirname')} --table dummy_table -m 1' &> exportTable.out");
         
        $this->log("Executing Job");
        exec("bash exportDatabase.sh ");
    }
}



