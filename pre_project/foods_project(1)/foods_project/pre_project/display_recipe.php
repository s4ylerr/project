<?php 
//TO DO RECIPE ID
$id_rec = 33;
header('Content-Type: text/html; charset=utf-8'); 
require_once('functions.php');
require_once('includes.php');
//change  `recipes`.`id`= 7
$recipe = array(array());
$i = 0;
$q = "SELECT * FROM `recipes` 
JOIN `users` ON `recipes`.`user_id`=`users`.`id`
JOIN `recipe_products_quantities` ON  `recipes`.`id`=`recipe_products_quantities`.`recipe_id`
JOIN `products` ON `recipe_products_quantities`.`product_id`=`products`.`id`
JOIN `measures` ON `recipe_products_quantities`.`measures_id` = `measures`.`id`
JOIN `food_types` ON `recipes`.`id_food_type` = `food_types`.`id_food`
WHERE `recipes`.`id`= $id_rec"; 


$res = mysqli_query($connect, $q);
if (mysqli_num_rows($res)) {
	while ($row = mysqli_fetch_assoc($res)) {
		foreach ($row as $key => $value) {
			$recipe[$i][$key] = $value;
		}
		$i++;
	}
}
/*echo "<pre>";
var_dump($recipe);
echo "</pre>";*/
$count = count($recipe);
echo "<p>".$recipe[0]['name']."</p>
<p>Калории/100 гр ".$recipe[0]['cal_recipe']."</p>
<p>Гликемичен индекс/100гр ".$recipe[0]['gi_recipe']."</p>
<p>".$recipe[0]['food_type']."</p>
<p>публикувана от ".$recipe[0]['username']." на ".$recipe[0]['date_published']."</p>";

echo	"<p>Продукти</p>
<ol>";
	
	for ($i=0; $i < $count ; $i++) { 
		echo "<li>".$recipe[$i]['product'].'-'.$recipe[$i]['quantity'].'-'.$recipe[$i]['measure']."</li>";
	}
	echo "</ol>";
	echo "<p>".$recipe[0]['description']."</p>";
	$q_photo = "SELECT `content_photo` FROM `recipes` WHERE `id` = $id_rec";
	$res_photo = mysqli_query($connect, $q_photo);
	$row_photo = mysqli_fetch_assoc($res_photo);
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_photo['content_photo'] ).'"/>';


	?>