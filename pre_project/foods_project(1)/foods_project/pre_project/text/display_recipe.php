<?php 
require_once('includes.php');
//change  `recipes`.`id`= 7
$q = "SELECT * FROM `recipes` 
JOIN `users` ON `recipes`.`user_id`=`users`.`id`
JOIN `recipe_products_quantities` ON  `recipes`.`id`=`recipe_products_quantities`.`recipe_id`
JOIN `products` ON `recipe_products_quantities`.`product_id`=`products`.`id`
JOIN `measures` ON `recipe_products_quantities`.`measures_id` = `measures`.`id`
JOIN `food_types` ON `recipes`.`id_food_type` = `food_types`.`id_food` WHERE `recipes`.`id`= 7"; 
?>