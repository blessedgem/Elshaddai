<?php

require "vendor/autoload.php";


$username =$_POST['username'];
$databasename =$_POST['databasename'];
$password =$_POST['password'];
$localhost=$_POST['localhost'];
$virtualhost=$_POST['virtualhost'];
$drivername = $_POST['databasetype'];
$dbport = $_POST['portnumber'];
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
		file_write_contents("exportDatabase.sh", "ssh cloudera@$virtualhost 'sqoop import-all-tables --connect 'jdbc:$databasetype://$localhost:$portnumber/$databasename' --username=$username --password=$password --warehouse-dir=/user/hive/warehouse  --hive-import -m 1' &> exportDatabse.out");

	}


	public function go()
	{
		$this->log("Executing Job");
		exec("./exportDatabase.sh ");
	}
}