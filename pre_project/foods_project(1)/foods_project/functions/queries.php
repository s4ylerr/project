<?php

function queries($connect, $query){
	
	$sql = mysqli_query($connect, $query)or die(mysqli_error());
	return($sql);

}
?>