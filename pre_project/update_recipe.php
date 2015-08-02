<?php 
//enters recipe name and number of products	
	//temporaliry!
$username = 'kokolina';
require_once('functions.php');
require_once('includes.php');
if (!empty($_GET)) {
	$id_rec = $_GET['id_rec'];
	$num = $_GET['num'];
	//данните, вече въведени за рецептата и за евентуална промяна
	$q_rec = "SELECT * FROM `recipes` WHERE `id` = $id_rec";
	$res_rec = mysqli_query($connect, $q_rec);
	$row_rec = mysqli_fetch_assoc($res_rec);
} else {
	$id_rec = "";
	$num = "";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="jquery-1.11.3.min.js"></script>
</head>
<body>
	<p>Промени </p>
	<form method="post" action="update_recipe.php">
		<label for="name">Заглавие на Вашата рецепта</label>
		<input type="text" name="name" id="name" value="<?php if(isset ($row_rec)) {echo $row_rec['name']; } else {echo ""; }?>">
		<label for="num">Въведете брой на продуктите, участващи в рецептата</label>
		<?php 
		
			
		$q_f = "SELECT * FROM `food_types` ORDER BY `food_type`";
			echo "<p><label for='f_t'>тип ястие</label>";
			echo "<p><select name='id_food' id='f_t'>";
			$result_f = mysqli_query($connect, $q_f);
			if (mysqli_num_rows($result_f)>0) {
				while ($row_f = mysqli_fetch_assoc($result_f)) {
					$food_type = $row_f['food_type'];
					$id_food = $row_f['id_food'];				
					
					echo "<option value='$id_food'";
					if (!empty($row_rec)) {
					if ($row_rec['id_food_type'] == $id_food) {
						echo " selected";
					}
					}
					echo ">".$food_type."</option>";

				}
			}
			echo "</select></p>";
		
			
			?>
		<input type="number" name="number" value="<?php echo $num; ?>">		
		<input type="hidden" name="id_user" value="<?php echo $row_rec['user_id']; ?>">
		<input type="hidden" name="id_rec" value="<?php echo $id_rec; ?>">
		<input type="submit" name="submit" value="въведи">
	</form>
	<?php 
	if (isset($_POST['submit'])) {
		$num = $_POST['number'];
		$name = $_POST['name'];
		$date = date('Y-m-d');
		$id_food = $_POST['id_food'];
			//id user
		$id = $_POST['id_user'];
		$id_rec = $_POST['id_rec'];
		//updating recipe into database				
		$q = "UPDATE `recipes` SET `name`= '$name', `id_food_type`= $id_food,`date_published`= '$date'
		WHERE `id`= $id_rec";
		if (mysqli_query($connect, $q)) {					
			echo $name." Рецептата съдържа ".$num." продукта.";
			echo "<a href='enter_recipe_details.php?id_rec=$id_rec&num=$num'>Премини нататък</a>";
		} 	
		
	} else {
		echo "Моля, попълнете информацията за рeцептата!";
	}
	?>
	<a href="delete_recipe.php?id_rec=<?php echo $id_rec?>">Изтрий</a>
	<a href="update_recipe.php?id_rec=<?php echo $id_rec?>">Промени</a>
</body>
</html>