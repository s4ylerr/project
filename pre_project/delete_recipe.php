<?php 
require_once('functions.php');
connect_database($connect);
$id_rec = $_GET['id_rec'];
$q = "	UPDATE `recipes` 
		SET `date_deleted` = '$date' 
		WHERE `id` = $id_rec";
$file_name = 'enter_recipe';
header_location($connect, $q, $file_name);
?>