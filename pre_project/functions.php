<?php
//connection to database
$connect = mysqli_connect('localhost', 'root', '', 'foods_project'); 
function connect_database($connect) {
	if (!$connect) {
		die ("Connection failed: mysqli_connect_error()");
	} else {
		echo "Connected successfully<br />";
	}
}
//for proper input!!
mysqli_set_charset($connect, 'utf8');

//getting the current date
date_default_timezone_set('Europe/Sofia');
$date = date('Y-m-d');

//header when deleting smth

function header_location($connect, $q, $file_name) {
	if (mysqli_query($connect, $q)) {
	header('Location:'.$file_name.'.php');
}
}


?>