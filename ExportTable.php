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

    public function ExportTable()
    {
        file_put_contents("exportTable.sh", "ssh cloudera@{$_POST['virtualhost']} \"sqoop import --connect 
            'jdbc:postgresql://{$_POST['localhost']}:5432/dummy' --username=postgres --password=gem 
             --warehouse-dir=/user/hive/warehouse/{$_POST['dirname']} --table dummy_table -hive-import -m 1\"
             &> exportTable.out");
    }



    public function go()
    {
        file_put_contents("exportTable.sh", "ssh cloudera@{$this->getAttribute('virtualhost')}
         \"sqoop import --connect 'jdbc:postgresql://{$this->getAttribute('localhost')}:5432/dummy' 
         --username=postgres --password=gem --warehouse-dir=/user/hive/warehouse/{$this->getAttribute('dirname')} 
         --table dummy_table --hive-import -m 1 \"
         &> exportTable.out");
         
        $this->log("Executing Job");
        exec("bash exportTable.sh ");
    }
}



