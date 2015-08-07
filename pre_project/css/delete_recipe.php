<?php 
require_once('template/header.php');

require_once('functions.php');
require_once('includes.php');
if (isset($_POST['submit'])) {

	$id_rec = $_GET['id_rec'];
	$q = "	UPDATE `recipes` 
		SET `date_deleted` = '$date' 
		WHERE `id` = $id_rec";
		$file_name = 'enter_recipe';

		if(mysqli_query($connect, $q)){

			echo 'Изтрихте рецептата<br /><a href="enter_recipe.php">Назад</a>';

		}else{
			echo '<a href="update_recipe.php">Назад</a>';
		}

}

?>
	<form method="post" action="">
		<label>Наистина ли искате да изтриете рецептата?</label><br />
		<input type="submit" name="submit" value="Изтрии" />
		<a href="enter_recipe.php" class="btn btn-primary btn-lg active" role="button">Отказ</a>
	</form>
<?php
require_once('template/footer.php');
?>