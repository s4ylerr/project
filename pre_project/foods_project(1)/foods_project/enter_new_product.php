<?php 
require_once('template/header.php');
	$username = $_SESSION['user'];
	require_once('functions.php');
	require_once('includes.php');

	/**to be deleted from here-->
	
		<!-- up to here to be deleted **/

		if (isset($_POST['submit'])) {

			$product = $_POST['product'];
			$cal = $_POST['cal'];
			$gi = $_POST['gi'];	
			$description = $_POST['description'];	
			//get user id, дали може да се включи във файла инклуд като повтарящ се код
			$q = "SELECT * FROM `users` WHERE `username` = '$username'";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);	
			$id_user= $row['id'];

			$insertp = "INSERT INTO `products` (`product`, `description`, `calories`, `gi`, `id_user`, `date_published`) 
			VALUES ('$product', '$description', '$cal','$gi', '$id_user', '$date')";
			
			$inser_query = mysqli_query($connect, $insertp)or die(mysqli_error());
			if ($inser_query) {
				echo "Успешно добавихте $product в базата данни!";
			}else{
				echo "Неуспешно добавяне на запис в базата данни! Моля опитайте по-късно!";
			}
		}
		?>
		<p>Количествата на продуктите се въвеждат в грамове или милилитри. Допустими са и количества като - чаена лъжичка /ч. л/, кафена лъжичка /к. л/, щипка, брой /бр./, глава/гл./, когато това е уместно. </p>
		
		<!-- форма за продуктите-->
		<form method="post" action="">	
			<p>Въведете данни за продукт</p>

			<label>Въведете продукт</label><br />		
			<input type="text" name="product" /><br />

			<label>Въведете калории в 100 г продукт</label><br />
			<input type="text" name="cal" value="" /><br />

			<label>Въведете гликемичен индекс за 100 г продукт</label><br />
			<input type="number" name="gi" value="" /><br />

			<label>Описание на продукта</label><br />
			<textarea name="description">
				
			</textarea><br />
			<input type="submit" value="запиши" name="submit" />
		</form>
		
		<a href="delete_new_product.php?product=<?php echo $product?>">Изтрий</a>
		<a href="update_new_product.php?product=<?php echo $product?>">Промени</a>
		<a href="photo_product.php?product=<?php echo $product?>">добави снимка</a>
<?php
require_once('template/footer.php');