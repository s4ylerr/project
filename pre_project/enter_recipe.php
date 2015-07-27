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
//продуктите, вече записани в базата
	
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
		<form method="get" action="enter_recipe.php">
			<label for="num">Въведете брой на продуктите</label>
			<input type="number" name="number" id="num">
			<input type="submit" name="submit" value="въведи">
		</form>
		<?php 
		//number of products per recipe
		$_SESSION['number'] = $_GET['number'];
		?>
		<form method="post" action="recipe.php">
			<?php 
			for ($i=1; $i <= $_SESSION['number'] ; $i++) { 
				$q = "SELECT * FROM `products`";
				$result = mysqli_query($conn, $q);
				//TODO labels
				echo "<p><select name='product'>";
				if (mysqli_num_rows($result)>0) {
					while ($row = mysqli_fetch_assoc($result)) {							
						echo "<option value='>".$row['product']."'>".$row['product']."</option>";
					}
				}
				echo "</select></p>";	
				$q_m = "SELECT * FROM `measures`";
				$result_m = mysqli_query($conn, $q_m);
				//TODO labels
				echo "<p><select name='measure'>";
				if (mysqli_num_rows($result_m)>0) {
					while ($row_m = mysqli_fetch_assoc($result_m)) {							
						echo "<option value='>".$row_m['measure']."'>".$row_m['measure']."</option>";
					}
				}
				echo "</select></p>";
				//TODO labels
				echo "<input type='number' name='quantity'>";

			}


			?>
			<p>не попълвайте, ако целта Ви е само да изчислите гликемичен индекс и калории, по-късно може да добавите и описание</p>
			<label for="description">Начин на приготвяне на рецептата</label>
			<textarea name="description" id="description"></textarea>
			<input type="submit" value="submit" name="submit">
		</form>
	</body>
	</html>