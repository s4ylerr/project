<?php

//header when deleting smth

function header_location($connect, $q, $file_name) {
	if (mysqli_query($connect, $q)) {
		header('Location:'.$file_name.'.php');
	}
}

function  get_id_user($var1, $var2, $var3){
	$q = "SELECT * FROM `users` WHERE `username` = 'kokolina'";
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