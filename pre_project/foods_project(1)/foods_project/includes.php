<?php 
//$connect = mysqli_connect('localhost', 'root', 'p8908271860', 'vratsad_foods_project'); 
$connect = mysqli_connect("localhost", "vratsad", "ProgramistB@c3", 'vratsad_foods_project');
	if (!$connect) {
		die ("Connection failed: mysqli_connect_error()");
	}
//for proper input!!
mysqli_set_charset($connect, 'utf8');
//getting the current date
date_default_timezone_set('Europe/Sofia');
$date = date('Y-m-d');