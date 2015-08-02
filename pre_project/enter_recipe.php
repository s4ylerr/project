	<?php 
//enters recipe name and number of products	
	//temporaliry!
	require_once('functions.php');
	require_once('includes.php');
	$username = 'kokolina';
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
		<p>Въведете данни за Вашата рецепта</p>
		<form method="post" action="enter_recipe.php">
			<label for="name">Заглавие на Вашата рецепта</label>
			<input type="text" name="name" id="name">
			<label for="num">Въведете брой на продуктите, участващи в рецептата</label>
			<input type="number" name="num" id="num">		
			<input type="submit" name="submit" value="въведи">
		</form>
		<?php 
		if (isset($_POST['submit'])) {
			$num = $_POST['num'];
			$name = $_POST['name'];
			$date = date('Y-m-d');
			$id_user = "";

		//getting the id of the user !!! from sessions username!!!!
			$q = "SELECT * FROM `users` WHERE `username` = 'kokolina'";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);	
			$id_user= $row['id'];
		//entering recipe into database
			$q_r = "INSERT INTO `recipes`(`name`, `date_published`, `user_id`) 
			VALUES ('$name','$date', $id_user)";
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
	</body>
	</html>