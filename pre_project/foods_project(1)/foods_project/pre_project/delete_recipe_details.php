<?php 
require_once('functions.php');
require_once('includes.php');
$id_rec = $_GET['id_rec'];
$q = "	UPDATE `recipe_products_quantities` 
		SET `date_deleted` = '$date' 
		WHERE `id` = $id_rec";
$file_name = 'enter_recipe_details';
header_location($connect, $q, $file_name);

?>