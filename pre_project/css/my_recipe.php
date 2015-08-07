<?php
require_once('template/header.php');
if ($_SESSION) {

if ($_GET) {
	$select_one_recipe = "SELECT * FROM recipes WHERE id = '$_GET[recipe]'";
	$q_recipe = mysqli_query($connect, $select_one_recipe)or die(mysqli_error());
	$r = mysqli_fetch_assoc($q_recipe);
	?>
		<table class="table table-bordered">
		  <tr><td colspan="5"><b><?php echo $r['name']; ?></b></td></tr>
		  <tr><td><b>Описание</b></td><td><b>Категория</b></td><td><b>Калории</b></td><td><b>Гликемичен индекс</b></td><td><b>Снимка</b></td></tr>
		  <tr>
		  <td><?php echo $r['description']; ?></td>
		  <td><?php echo $r['id_food_type']; ?></td>
		  <td><?php echo $r['cal_recipe']; ?></td>
		  <td><?php echo $r['gi_recipe']; ?></td>
		  <td>
		  <?php
			  if ($r['content_photo']) {
				echo '<img width="150" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'"/> ';
			}
		   ?>
		   </td>
		  </tr>
		</table>
		<a href="main.php" class="btn btn-success btn-sm active" role="button">Всички рецепти</a><br /><br />
	<?php
}
}
require_once('template/footer.php');