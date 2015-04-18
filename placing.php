<?php

error_reporting(0);
ini_set ('display_errors', 0);

if( ! ini_get('date.timezone') )
{
	date_default_timezone_set('GMT');
}

spl_autoload_register(function($class){
	include __DIR__ . '/classes/' . $class . '.php';
});

$teamname = 'ksar';

$request = new Request($argv);
$worker = new Worker($request, $teamname);
$worker->run();
