<?php 
$connect = mysqli_connect('localhost', 'root', '', 'foods_project'); 
	if (!$connect) {
		die ("Connection failed: mysqli_connect_error()");
	} else {
		echo "Connected successfully<br />";
	}




$query = "SELECT `content_photo`, `name_photo`, `type_photo`, `size_photo`,  FROM `products` WHERE id = 152";

$image = mysql_query($connect, $query);
$image = mysql_fetch_assoc($image);
$image = $image['content_photo'];
$name = $image['name_photo'];
$type = $image['type_photo'];
$size = $image['size_photo'];
header("Content-length: $size");
header("Content-type: $type");
header("Content_Disposition: attachment; filename=$name");

echo $image;
   


?>