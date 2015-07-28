
<?php 
//create connection
session_start();
	//temporaliry!
//set username!!!!
$conn = mysqli_connect('localhost', 'root', '', 'foods_project');
//check connection
if (!$conn) {
	die ("Connection failed: mysqli_connect_error()");
} 
//echo "Connected successfully<br />";
mysqli_set_charset($conn, 'utf8');
//продуктите, вече записани в базата
	//number of products per recipe
if (!empty($_GET)) {
	//recipe_id
	$id = $_GET['id'];
	//num products
	$num = $_GET['num'];
} else {
	$id="";
	$num = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>	
	<form method="post" action="recipe3.php">
		<input type="hidden" name="recipe_id" value="<?php echo $id?>">
		<input type="hidden" name="num_prod" value="<?php echo $num?>">
		<!--recipe products and measures-->
		<?php 
		for ($i=0; $i < $num; $i++) { 
			$q = "SELECT * FROM `products`";
			$result = mysqli_query($conn, $q);
			$pr = $i+1;
			echo "<p><label for='prod'".$i."'>Продукт".$pr."</label>";
			echo "<select name='product[]' id='prod".$i."'>";
			if (mysqli_num_rows($result)>0) {
				while ($row = mysqli_fetch_assoc($result)) {	
					$product = $row['product'];
					$prod_id = $row['id'];				
					echo "<option value='$prod_id'>$product</option>";
				}
			}
			echo "</select></p>";	
			$q_m = "SELECT * FROM `measures`";
			$result_m = mysqli_query($conn, $q_m);
			echo "<p><label for='meas'".$i."'>Количество</label>";
			echo "<p><select name='measure[]' id='meas".$i."'>";
			if (mysqli_num_rows($result_m)>0) {
				while ($row_m = mysqli_fetch_assoc($result_m)) {
					$measure = $row_m['measure'];
					$meas_id = $row_m['id'];						
					echo "<option value='$meas_id'>$measure</option>";
				}
			}
			echo "</select></p>";
				//TODO labels
			echo "<input type='number' name='quantity[]'>";
		}

		?>
		<p>не попълвайте, ако целта Ви е само да изчислите гликемичен индекс и калории, по-късно може да добавите и описание</p>
		<label for="description">Начин на приготвяне на рецептата</label>
		<textarea name="description" id="description"></textarea>
		<input type="submit" value="submit" name="submit">
	</form>
	<?php
	if (isset($_POST['submit'])) {
		$recipe_id = $_POST['recipe_id'];
		$quantity =  $_POST['quantity'];
		$measure = $_POST['measure'];
		$product = $_POST['product'];
		$description = $_POST['description'];
	//num of prod
		$num = $_POST['num_prod'];
		//var_dump($quantity);
		//var_dump($measure);
		//var_dump($product);
		//echo $num.' ';
		//echo $recipe_id;
		$flag = 0;
		$flag_des = 0;
		for ($k = 0; $k < $num; $k++) { 
				//ид продукт
			$pr_id = $product[$k];
			//ид мерна единица
			$meas_id = $measure[$k];
			//количество
			$quant = $quantity[$k];			
			$q_r = "INSERT INTO `recipe_products_quantities`
			(`recipe_id`, `product_id`, `measures_id`, `quantity`) 
			VALUES ($recipe_id, $pr_id, $meas_id, $quant)";
			if (mysqli_query($conn, $q_r)) {
				$flag = 1;
			} else {
				$flag = 0;
			}
		}
		//запис на описанието на рецептата
		$q_des = "	UPDATE `recipes` 
					SET `description`='$description'
					WHERE `id` = $recipe_id ";
		if (mysqli_query($conn, $q_des)) {
			$flag_des = 1;
		} else {
			$flag_des = 0;
		}
		if ($flag == 1 && $flag_des == 1) {
			echo "Успешно записахте всички продукти и описание!";
		} else {
			echo "Опитайте отново!";
		}

	}


	?>

</body>
</html>