<?php 
	//new product
	$username = 'kokolina';
	require_once('functions.php');
	require_once('includes.php');
	if(!empty($_GET)) {
		$product = $_GET['product'];
	} else {
		$product = '';
	} 	
	//retrieving product info
	$q = "SELECT * FROM `products` WHERE `product` = '$product'";
	$result = mysqli_query($connect, $q);
	if (mysqli_num_rows($result)>0) {
		$row = mysqli_fetch_assoc($result);
	}
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
	<!-- up to here-->
		<p>Количествата на продуктите се въвеждат в грамове или милилитри. Допустими са и количества като - чаена лъжичка /ч. л/, кафена лъжичка /к. л/, щипка, брой /бр./, глава/глави/, когато това е уместно. </p>
		<p>Въведете данни за Вашата рецепта</p>
		<!-- форма за продуктите-->
		<form method="post" action="update_new_product.php">	
			<input type="hidden" name="username" value="<?php echo $username;?>">
			<input type="hidden" name="id" value="<?php echo $row['id']?>">			
			<p>Въведете данни за продукт</p>			
			<label for="nm">Въведете продукт</label>			
			<input type="text" name="product" id="nm" value="<?php if(isset($row['product'])) {echo $row['product']; }?>">
			<label for="cal">Въведете калории в 100 г продукт</label>
			<input type="number" name="cal" id="cal" value="<?php echo $row['calories'];?>">
			<label for="gi">Въведете гликемичен индекс за 100 г продукт</label>
			<input type="number" name="gi" id="gi" value="<?php echo $row['gi'];?>">		
			<input type="submit" value="запиши" name="submit">
		</form>
		<?php 
		if (!empty($_POST)) {
			$id = $_POST['id'];
			$product = $_POST['product'];
			$cal = $_POST['cal'];
			$gi = $_POST['gi'];	
			$q_new_info = "UPDATE `products` 
						SET `product`='$product',
						`calories`=$cal,
						`gi`=$gi
						WHERE `id` = $id";
			if (mysqli_query($connect, $q_new_info)) {
				echo 'Променихте успешно информацията за продукта!';
			} else {
				echo 'Опитайте отново!';
			}
		} 
		?>
		<a href="product_photo.php?product=<?php echo $product?>">промени снимка</a>
		</body>
		</html>