	<?php 
//create connection
	session_start();
	//temporaliry!
	//!!set username
	$conn = mysqli_connect('localhost', 'root', '', 'foods_project');
//check connection
	if (!$conn) {
		die ("Connection failed: mysqli_connect_error()");
	} 
//echo "Connected successfully<br />";
	mysqli_set_charset($conn, 'utf8');
	date_default_timezone_set('Europe/Sofia');
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
			<input type="number" name="number">		
			<input type="submit" name="submit" value="въведи">
		</form>
		<?php 
		if (isset($_POST['submit'])) {
			$num = $_POST['number'];
			$name = $_POST['name'];
			$date = date('Y-m-d');
			//условие да не се повтарят имената на рецептите в базата 
			$q_name = "SELECT `name` FROM `recipes`";
			$res_name = mysqli_query($conn, $q_name);
			$flag = 0;
			if (mysqli_num_rows($res_name) > 0) {
		while ($row_name = mysqli_fetch_assoc($res_name)) {
			foreach ($row_name as $value) {
				if ($row_name['name'] == $name) {
					$flag = 1;

				}								
			}
		}
	}
	if ($flag == 1) {
		echo "Рецепта, с такова име вече съществува в базата дании. Моля прегледайте вече съществуващата рецепта и променете името!";
	} 
		//getting the id of the user
			$q_user = "SELECT `id` FROM `users` WHERE `username` = '$username'";
			$result_user = mysqli_query($conn, $q_user);
			$row_user = mysqli_fetch_assoc($result_user);
			$id = $row_user['id'];
		//entering recipe into database
			$q_r = "INSERT INTO `recipes`(`name`, `date_published`, `user_id`) 
			VALUES ('$name','$date', $id)";
			if (mysqli_query($conn, $q_r)) {
				$q_r = "SELECT `id` FROM `recipes` WHERE `name` = '$name'";
				$result_recipe = mysqli_query($conn, $q_r);
				$row_recipe = mysqli_fetch_assoc($result_recipe);
			
				$id_rec = $row_recipe['id'];
				echo $name;
				//echo $id_rec;
			//промени или изтрий името
				echo "<a href='recipe3.php?id=$id_rec&num=$num'>Премини нататък</a>";
			} else {
				echo "Try again!";
			}
		} else {
			echo "Моля, попълнете информацията за рeцептата!";
		}
		?>
	</body>
	</html>