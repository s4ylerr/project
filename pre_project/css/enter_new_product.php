	<?php 
	$username = 'kokolina';
	require_once('functions.php');
	require_once('includes.php');
	?>
	<!-- to be deleted from here-->
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
		<!-- up to here to be deleted-->
		<p>Количествата на продуктите се въвеждат в грамове или милилитри. Допустими са и количества като - чаена лъжичка /ч. л/, кафена лъжичка /к. л/, щипка, брой /бр./, глава/гл./, когато това е уместно. </p>
		<p>Въведете данни за Вашата рецепта</p>
		<!-- форма за продуктите-->
		<form method="post" action="enter_new_product.php">	
			<input type="hidden" name="username" value="<?php echo $username;?>">
			<p>Въведете данни за продукт</p>
			<label for="nm">Въведете продукт</label>			
			<input type="text" name="product" id="nm">
			<label for="cal">Въведете калории в 100 г продукт</label>
			<input type="number" name="cal" id="cal">
			<label for="gi">Въведете гликемичен индекс за 100 г продукт</label>
			<input type="number" name="gi" id="gi">		
			<input type="submit" value="запиши" name="submit">
		</form>
		<?php 
		if (isset($_POST['submit'])) {
			$username = $_POST['username'];
			$product = $_POST['product'];
			$cal = $_POST['cal'];
			$gi = $_POST['gi'];	
			$id_user = "";
			//get user id, дали може да се включи във файла инклуд като повтарящ се код
			$q = "SELECT * FROM `users` WHERE `username` = '$username'";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);	
			$id_user= $row['id'];
			$q = "INSERT INTO `products`(`product`, `calories`, `gi`, `user_id`, `date_published`) 
			VALUES ('$product', $cal, $gi, $id_user, '$date')";
			if (mysqli_query($connect, $q)) {
				echo "Успешен запис!";
			} else {
				echo "Този продукт съществува в базата данни!";
			}
		}
		?>
		<a href="delete_new_product.php?product=<?php echo $product?>">Изтрий</a>
		<a href="update_new_product.php?product=<?php echo $product?>">Промени</a>
		<a href="photo_product.php?product=<?php echo $product?>">добави снимка</a>
	</body>
	</html>