<?php
require "vendor/autoload.php";
require "ExportJob.php";
require "general2.php";

$data = require "ajumamoro.conf.php";;
$scheduler = \ajumamoro\Scheduler::connect($data['store']);
$scheduler->add(new ExportJob());
$scheduler->add(new ImportJob());