	<?php 
//create connection
	session_start();
	$usernane = $_SESSION['username'];
$conn = mysqli_connect('localhost', 'root', '', 'foods_project');
//check connection
if (!$conn) {
	die ("Connection failed: mysqli_connect_error()");
} 
//echo "Connected successfully<br />";
mysqli_set_charset($conn, 'utf8');
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
	<form method="post" action="enter_recipe1.php">
	
	<!-- форма за продуктите-->

	<p>Въведете данни за продукт</p>
	<label for="nm">Въведете продукт</label>
	<input type="hidden" name="$username">
		<input type="text" name="name" id="nm">
		<label for="cal">Въведете калории в 100 г продукт</label>
		<input type="number" name="cal" id="cal">
		<label for="gi">Въведете гликемичен индекс за 100 г продукт</label>
		<input type="number" name="gi" id="gi">		
		<input type="submit" value="запиши" name="">
	</form>
	<?php 
if (!empty($_GET)) {
	$name = $_GET['name'];
	$cal = $_GET['cal'];
	$gi = $_GET['gi'];	
	$q = "INSERT INTO `products`(`product`, `calories`, `GI`) VALUES ('$name', $cal, $gi)";
	if (mysqli_query($conn, $q)) {
		echo "Успешен запис!";
	}
}
	?>
</body>
</html>