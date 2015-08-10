<?php 
require_once('functions.php');
require_once('includes.php');
$product = $_GET['product'];
$q = "	UPDATE `products` 
		SET `date_deleted` = '$date' 
		WHERE `product` = '$product'";
$file_name = 'enter_new_product';
header_location($connect, $q, $file_name);
?>