	<?php 
	//new product
	$username = 'kokolina';
	require_once('functions.php');
	connect_database($connect);
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
		<p>Количествата на продуктите се въвеждат в грамове или милилитри. Допустими са и количества като - чаена лъжичка /ч. л/, кафена лъжичка /к. л/, щипка, брой /бр./, глава/глави/, когато това е уместно. </p>
		<p>Въведете данни за Вашата рецепта</p>
		<!-- форма за продуктите-->
		<form method="post" action="enter_new_product.php">	
			<input type="hidden" name="username" value="<?php echo $username;?>">
			<p>Въведете данни за продукт</p>
			<label for="nm">Въведете продукт</label>
			
			<input type="text" name="name" id="nm">
			<label for="cal">Въведете калории в 100 г продукт</label>
			<input type="number" name="cal" id="cal">
			<label for="gi">Въведете гликемичен индекс за 100 г продукт</label>
			<input type="number" name="gi" id="gi">		
			<input type="submit" value="запиши" name="submit">
		</form>
		<?php 

		if (isset($_POST['submit'])) {
			$username = $_POST['username'];
			$name = $_POST['name'];
			$cal = $_POST['cal'];
			$gi = $_POST['gi'];	
			
			$q = "SELECT * FROM `users` WHERE `username` = '$username'";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);
			$user_id = $row['id'];
			//условие да не се повтарят имената на продуктите в базата 
			$q_name = "SELECT `product` FROM `products`";
			$res_name = mysqli_query($connect, $q_name);
			$flag = 0;
			if (mysqli_num_rows($res_name) > 0) {
				while ($row_name = mysqli_fetch_assoc($res_name)) {
					foreach ($row_name as $value) {
						if ($row_name['product'] == $name) {
							$flag = 1;

						}								
					}
				}
			}		
			if ($flag == 1) {
				echo "Такъва продукт вече съществува в базата данни!";
			} 		
			
			$q = "INSERT INTO `products`(`product`, `calories`, `gi`, `user_id`) 
			VALUES ('$name', $cal, $gi, $user_id)";
			if (mysqli_query($connect, $q)) {
				echo "Успешен запис!";
			}
		}
		?>
		<a href="delete_new_product.php?product=<?php echo $name?>">Изтрий</a>
		<a href="update_new_product.php?product=<?php echo $name?>">Промени</a>
	</body>
	</html>