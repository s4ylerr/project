	<?php 
//enters recipe name and number of products	
	//temporaliry!
	require_once('template/header.php');
	require_once('functions.php');
	require_once('includes.php');
	$username = $_SESSION['user'];
	?>
	
		<p>Въведете данни за Вашата рецепта</p>
		<form method="post" action="enter_recipe.php">
			<label for="name">Заглавие на Вашата рецепта</label>
			<input type="text" name="name" id="name">
			<?php 
$q_f = "SELECT * FROM `food_types` ORDER BY `food_type`";
			
			echo "<p><label for='f_t'>тип ястие</label>";
			echo "<p><select name='id_food' id='f_t'>";
			$result_f = mysqli_query($connect, $q_f);
			if (mysqli_num_rows($result_f)>0) {
				while ($row_f = mysqli_fetch_assoc($result_f)) {
					$food_type = $row_f['food_type'];
					$id_food = $row_f['id_food'];						
					echo "<option value='$id_food'>$food_type</option>";
				}
			}
			echo "</select></p>";
			
			?>
			<label for="num">Въведете брой на продуктите, участващи в рецептата</label>
			<input type="number" name="num" id="num">		
			<input type="submit" name="submit" value="въведи">
		</form>
		<?php 
		if (isset($_POST['submit'])) {
			$num = $_POST['num'];
			$name = $_POST['name'];
			$id_food = $_POST['id_food'];
			
			$date = date('Y-m-d');
			$id_user = "";

		//getting the id of the user !!! from sessions username!!!!
			$q = "SELECT * FROM `users` WHERE `username` = '$username'";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);	
			$id_user= $row['id'];
		//entering recipe into database
			$q_r = "INSERT INTO `recipes`(`name`, `id_food_type`, `date_published`, `user_id`)
			 VALUES ('$name', $id_food,'$date','$id_user')";
			if (mysqli_query($connect, $q_r)) {
				$q = "SELECT `id` FROM `recipes` WHERE `name` = '$name'";
				$result = mysqli_query($connect, $q);
				$row = mysqli_fetch_assoc($result);
					//recipe id
				$id_rec = $row['id'];
				echo $name." Рецептата съдържа ".$num." продукта.";			
			//промени или изтрий името
				echo "<a href='enter_recipe_details.php?id_rec=$id_rec&num=$num'>Премини нататък</a>";
			} else {
				echo "Try again!";
			}			
		} else {
			echo "Моля, попълнете информацията за рeцептата!";
		}
		?>
		<a href="delete_recipe.php?id_rec=<?php echo $id_rec?>">Изтрий</a>
		<a href="update_recipe.php?id_rec=<?php echo $id_rec?>&num=<?php echo $num; ?>">Промени</a>
		<?php
require_once('template/footer.php');