<?php 
header('Content-length: $file_size');
header('Content-type: $file_type');
header('Content-Disposition: attachment; filename = $file_name');
include('includes.php');
$q = "SELECT `content_photo`, `name_photo`, `type_photo`, `size_photo` FROM `recipes` WHERE `id` = 19";
$result = mysqli_query($connect, $q);
list($content, $file_name, $file_type, $file_size) = mysqli_fetch_array($result);

?>