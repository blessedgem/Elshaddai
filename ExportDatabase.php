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

	public ExportDatabase()
	{
		var virtualIp = $virtualhost;
	}


	public function go()
	{
		$this->log("Executing Job");
		exec("./exportDatabase.sh ");
	}
}