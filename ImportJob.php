<?php

require "vendor/autoload.php";

class ImportJob extends \ajumamoro\Job
{
	public function go()
	{
		$this->log("Executing Job");
		exec("./import.sh");
	}
}