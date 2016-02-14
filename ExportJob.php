<?php

require "vendor/autoload.php";

class ExportJob extends \ajumamoro\Job
{
	public function go()
	{
		$this->log("Executing Job");
		exec("./export.sh");
	}
}