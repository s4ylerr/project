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

function  get_id_user($var1, $var2, $var3){
	$q = "SELECT * FROM `users` WHERE `username` = '$var1'";
	$result = mysqli_query($var3, $q);
	$row = mysqli_fetch_assoc($result);	
	$var3 = $row['id'];
}


//данните, вече въведени за рецептата 
	function recipe_details($var1, $var2) {
	$q = "SELECT * FROM `recipes` WHERE `id` = $var1";
	$result = mysqli_query($var2, $q);
	$row = mysqli_fetch_assoc($result);
}
	

?>