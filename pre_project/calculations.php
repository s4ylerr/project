<?php 
header('Content-Type: text/html; charset=utf-8'); 
require_once('functions.php');
require_once('includes.php');
//TODO with sessions
$id_rec = 26;
$i = 0;
$j = 0;
$info = array(array());
//query 2 - measures id for 

$q_2 = "SELECT `measures_id`, `measure` 
FROM `recipe_products_quantities` JOIN `measures` 
ON `recipe_products_quantities`.`measures_id`= `measures`.`id` 
WHERE `recipe_id` = $id_rec";
$result_2 = mysqli_query($connect, $q_2);
if (mysqli_num_rows($result_2) > 0) {
	while($row_2 = mysqli_fetch_assoc($result_2)) {
		foreach ($row_2 as $key => $value) {
			$info[$j]['measure'] = $value;
		}
		$j++;			
	}
}
//query 1 all info for calculations
$q_1 = "SELECT `recipe_products_quantities`.`id`,`recipe_id`, `product_id`, 
`measures_id`, `quantity`, 'quantity_gr', `calories`, `gi`, coef_to_gr 
FROM `recipe_products_quantities` JOIN  `products` 
ON  `recipe_products_quantities`.`product_id`= `products`.`id` 
WHERE `recipe_id` = $id_rec";
$result_1 = mysqli_query($connect, $q_1);

if (mysqli_num_rows($result_1) > 0) {
	while($row_1 = mysqli_fetch_assoc($result_1)) {
		foreach ($row_1 as $key => $value) {
			$info[$i][$key] = $value;
		}
		$i++;			
	}
}

echo "<pre>";
var_dump($info);
echo "</pre>";
	//CALCULATIONS
$count = count($info);
for ($p=0; $p < $count ; $p++) { 	
	if ($info[$p]['measures_id'] == 32 || $info[$p]['measures_id'] == 29) {
		$info[$p]['quantity_gr'] = $info[$p]['quantity']*$info[$p]['coef_to_gr'];
	} elseif ($info[$p]['measures_id'] == 28 ) {
		$info[$p]['quantity_gr'] = $info[$p]['quantity'];
	} elseif ($info[$p]['measures_id']!=='бр.' && $info[$p]['measure']!=='мл' && $info[$p]['measure']!=='гр') {
		$info[$p]['quantity_gr']=0;
	}
}
echo "<pre>";
var_dump($info);
echo "</pre>";

//entering info about the weight in gr

for ($k = 0; $k < $count; $k++) { 
	echo $info[$k]['id'];
	echo $info[$k]['quantity_gr'];
	$quantity_gr = $info[$k]['quantity_gr'];
	$id = $info[$k]['id'];
	$q_r = "UPDATE `recipe_products_quantities` 
	SET `quantity_gr`= $quantity_gr
	WHERE `id`=$id";
	if (mysqli_query($connect, $q_r)) {
		echo "Success";
	} else {
		echo "try again";
	}
}
//SUM OF all products weight

$q_s = "SELECT SUM(`quantity_gr`) FROM `recipe_products_quantities` WHERE `recipe_id` = $id_rec";
//"SELECT SUM(`quantity_gr`)  as row - row ще ми е индекса на резултата
$result_s = mysqli_query($connect, $q_s);
$row_s = mysqli_fetch_assoc($result_s);
///!!!!Как се записват резултатите от агрегиращите функции
echo $row_s["SUM(`quantity_gr`)"].'общо тегло';

//изчисляване на относителното тегло на всеки продукт в рецептата спрямо общото тегло - percent_weight
if($row_s["SUM(`quantity_gr`)"]== 0){
	for ($s=0; $s < $count ; $s++) { 
		$info[$s]['percent_weight'] = 0;
		

	}
} else {
	for ($s=0; $s < $count ; $s++) { 
		$percent_weight = ($info[$s]['quantity_gr']*100)/$row_s["SUM(`quantity_gr`)"];
		$info[$s]['percent_weight'] = round($percent_weight, 2);
		echo $percent_weight.'отн тегло '.'<br />';
	}
}
// ГЛИКЕМИЧЕН ИНДЕКС И КАЛОРИИ НА РЕЦЕПТАТА 
$cal_recipe = 0;
$gi_recipe = 0;
for ($v=0; $v < $count ; $v++) {
	$gi_prod = $info[$v]['percent_weight']*$info[$v]['gi']/100;
	$cal_prod = $info[$v]['percent_weight']*$info[$v]['calories']/100;
	$gi_recipe += $gi_prod;
	echo $gi_prod.'гл индекс прод '.'<br />';
	$cal_recipe += $cal_prod;
	echo $cal_prod.'кал  прод '.'<br />';
}
$gi_recipe = round($gi_recipe);
$cal_recipe = round($cal_recipe);
//ЗАПИС В БАЗАТА НА ГИ И КАЛ НА РЕЦЕПТАТА
//???
/*$id_recipe = $info[0]['recipe_id']*/
$q_r = "UPDATE `recipes` 
SET `cal_recipe`= $cal_recipe,
`gi_recipe` = $gi_recipe
WHERE `id`=$id_rec";
if (mysqli_query($connect, $q_r)) {
	echo "Success";
} else {
	echo "try again";
}
echo "<pre>";
var_dump($info);
echo "</pre>";?>