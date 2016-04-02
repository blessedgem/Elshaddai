<?php

require "vendor/autoload.php";

class ExportJob extends \ajumamoro\Job
{
	private $clouderaIP;
	private $localhostIP;
	private $newfolder;


	public function go()
	{
		$this->log("Executing Job");
		exec("./export.sh ");
	}
}