<?php 
require_once('template/header.php');
require_once('functions.php');
require_once('includes.php');
//TODO with sessions
$id_rec = $_GET['displayr'];
$num = $_GET['num'];
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

//entering info about the weight in gr

for ($k = 0; $k < $count; $k++) { 

	$quantity_gr = $info[$k]['quantity_gr'];
	$id = $info[$k]['id'];
	$q_r = "UPDATE `recipe_products_quantities` 
	SET `quantity_gr`= $quantity_gr
	WHERE `id`=$id";
	if (mysqli_query($connect, $q_r)) {
		//echo "Success";
	} else {
		echo "Работим по отстраняването на проблема";
	}
}
//SUM OF all products weight

$q_s = "SELECT SUM(`quantity_gr`) FROM `recipe_products_quantities` WHERE `recipe_id` = $id_rec";
//"SELECT SUM(`quantity_gr`)  as row - row ще ми е индекса на резултата
$result_s = mysqli_query($connect, $q_s);
$row_s = mysqli_fetch_assoc($result_s);
///!!!!Как се записват резултатите от агрегиращите функции

//изчисляване на относителното тегло на всеки продукт в рецептата спрямо общото тегло - percent_weight
if($row_s["SUM(`quantity_gr`)"]== 0){
	for ($s=0; $s < $count ; $s++) { 
		$info[$s]['percent_weight'] = 0;
		

	}
} else {
	for ($s=0; $s < $count ; $s++) { 
		$percent_weight = ($info[$s]['quantity_gr']*100)/$row_s["SUM(`quantity_gr`)"];
		$info[$s]['percent_weight'] = round($percent_weight, 2);
		
	}
}
// ГЛИКЕМИЧЕН ИНДЕКС И КАЛОРИИ НА РЕЦЕПТАТА 
$cal_recipe = 0;
$gi_recipe = 0;
for ($v=0; $v < $count ; $v++) {
	$gi_prod = $info[$v]['percent_weight']*$info[$v]['gi']/100;
	$cal_prod = $info[$v]['percent_weight']*$info[$v]['calories']/100;
	$gi_recipe += $gi_prod;
	
	$cal_recipe += $cal_prod;
	
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
	//echo "Success";
} else {
	echo "Работим по отстраняването на проблема!";
}
$recipe = array(array());
$i = 0;
$q = "SELECT *, `recipes`.`date_published` as dp, `users`.`username` as `ur` FROM `recipes` 
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
?>
<div class="row";>	
	<div class="text col-xs-10 col-xs-offset-1">
		<div class="row">
			<div class="col-xs-6">
				<?php
				echo "<h3>".$recipe[0]['name']."</h3>
				<div>
				<p>Калории/100 гр ".$recipe[0]['cal_recipe']."</p>
				<p>Гликемичен индекс/100гр ".$recipe[0]['gi_recipe']."</p>
				<p> <em>категория </em>".$recipe[0]['food_type']."</p>
				<p> <em>публикувана от ".$recipe[0]['ur']." на ".$recipe[0]['dp']."</em></p>
				</div>";


				echo	"<h4>Продукти</h4>
				<ol>";

					for ($i=0; $i < $count ; $i++) { 
						echo "<li>".$recipe[$i]['product'].'-'.$recipe[$i]['quantity'].'-'.$recipe[$i]['measure']."</li>";
					}
					echo "</ol>
				</div>
				<div class='col-xs-6'>";



					echo "<p>".$recipe[0]['description']."</p>";
					$q_photo = "SELECT `content_photo` FROM `recipes` WHERE `id` = $id_rec";
					$res_photo = mysqli_query($connect, $q_photo);
					$row_photo = mysqli_fetch_assoc($res_photo);
					echo '<img src="data:image/jpeg;base64,'.base64_encode( $row_photo['content_photo'] ).'"/><br />';
					echo '<a href="update_recipe_details.php?updaterd='. $id_rec .'&num='.$num.'">Промени</a>
				</div>';
				?>
				</div>
			</div>
		</div>
		<?php
		require_once('template/footer.php');
		?>
