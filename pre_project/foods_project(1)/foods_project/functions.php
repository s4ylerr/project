<?php
//header when deleting smth
function header_location($connect, $q, $file_name) {
	if (mysqli_query($connect, $q)) {
		header('Location:'.$file_name.'.php');
	}
}
?>