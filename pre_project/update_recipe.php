<?php 
//enters recipe name and number of products	
	//temporaliry!
$username = 'kokolina';
require_once('functions.php');
	connect_database($connect);
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
	<p>Промени</p>
	<form method="post" action="update_recipe.php">
		<label for="name">Заглавие на Вашата рецепта</label>
		<input type="text" name="name" id="name" value="<?php if(isset ($row_rec)) {echo $row_rec['name']; } else {echo ""; }?>">
		<label for="num">Въведете брой на продуктите, участващи в рецептата</label>
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
			//id user
		$id = $_POST['id_user'];
		$id_rec = $_POST['id_rec'];
		//checking for uniqueness of the name
		$flag = 0;
		$q_rec = "SELECT * FROM `recipes` WHERE `id` = $id_rec";
		$res_rec = mysqli_query($connect, $q_rec);
		$row_rec = mysqli_fetch_assoc($res_rec);
			//updating recipe into database
			echo $id_rec;		
			$q_r = "UPDATE `recipes` SET `name`= '$name', `date_published`= '$date'
			WHERE `id`= $id_rec";
			if (mysqli_query($connect, $q_r)) {					
				echo $name." Рецептата съдържа ".$num." продукта.";
				echo "<a href='enter_recipe_details.php?id_rec=$id_rec&num=$num'>Премини нататък</a>";
			} 	
		
	} else {
		echo "Моля, попълнете информацията за рeцептата!";
	}
	?>
	<!--Само на този запис ще му бъде позволенода се изтрива напълно!?????-->
	<a href="delete_recipe.php?id_rec=<?php echo $id_rec?>">Изтрий</a>
	<a href="update_recipe.php?id_rec=<?php echo $id_rec?>">Промени</a>
</body>
</html>