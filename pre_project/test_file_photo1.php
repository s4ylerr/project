<?php 
$connect = mysqli_connect('localhost', 'root', '', 'foods_project'); 
	if (!$connect) {
		die ("Connection failed: mysqli_connect_error()");
	} else {
		echo "Connected successfully<br />";
	}

$q = "SELECT `conent` FROM `pictures` WHERE id = 150";
$result = mysqli_query($connect, $q);
$row = mysqli_fetch_assoc($result);
echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['conent'] ).'"/>';



?>