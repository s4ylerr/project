<?php 
require_once('template/header.php');
require_once('functions.php');
require_once('includes.php');
?>
<div class="row enterr" style="background-image:url('images/Colorful.jpg')";>	
	<?php
	if (isset($_POST['submit'])) {
		$id_rec = $_GET['id_rec'];
		$q = "	UPDATE `recipes` 
		SET `date_deleted` = '$date' 
		WHERE `id` = $id_rec";
		$file_name = 'enter_recipe';
		if(mysqli_query($connect, $q)){
			echo '<div class="row deleted text-center"><div class="col-xs-4 col-xs-offset-4"><h3 class="text-defailt bg-info">Изтрихте рецептата !</h3><br/><a class="btn btn-info active" role="button" href="enter_recipe.php">Назад</a></div></div>';
		}else{
			echo '<div class="row deleted text-center"><div class="col-xs-6 col-xs-offset-3"><a  class="btn btn-info active" role="button" href="update_recipe.php">Назад</a></div></div>';
		}
	}
	?>
	<div class="col-xs-12 just">
		<div class="first_enterr text-center col-xs-8 col-xs-offset-2">
			<form method="post" action="" class="form-xorizontal">
				
				<div class="form-group">
					<label>Наистина ли искате да изтриете рецептата?</label><br />
					<div class="form-group"> <a href="enter_recipe.php" class="btn btn-primary active" role="button">ОТКАЗ</a></div>
					<button type="submit" name="submit" class="btn btn-danger">ИЗТРИЙ</button>
				</div>				

			</form>
			
			
		</div>
	</div>
</div>

<?php
require_once('template/footer.php');