<?php
require_once('template/header.php');
if ($_SESSION) {


$select_id_user = "SELECT id FROM users WHERE username = '$_SESSION[user]'";
$query_id_user = mysqli_query($connect, $select_id_user)or die(mysqli_error());
$fetch_row = mysqli_fetch_assoc($query_id_user);

$my_recipe = "SELECT * FROM recipes WHERE user_id = '$fetch_row[id]' AND date_deleted IS NULL ORDER BY id DESC";
$query_recipe = mysqli_query($connect, $my_recipe)or die(mysqli_error());
echo "<br /><a class='btn btn-primary active' role='button' href='enter_recipe.php'>Добави рецепта</a>";
echo ' <a href="enter_new_product.php" class="btn btn-primary active" role="button">ДОБАВИ ПРОДУКТ</a><br /><br />';
?>
	<table class="table table-bordered">
		  <tr><td class="title" colspan="3"><b>ВСИЧКИ РЕЦЕПТИ</b></td></tr>
		  <tr><td><b>Име</b></td><td><b>Описание</b></td><td><b>Преглед</b></td></tr>
<?php
if (mysqli_num_rows($query_recipe)>0) {
	while ($r = mysqli_fetch_assoc($query_recipe)) {
		$scount = "SELECT COUNT(*) as crp FROM `recipe_products_quantities` WHERE `recipe_id` = $r[id]";
		$q = mysqli_query($connect, $scount);
		$rcount = mysqli_fetch_assoc($q);
		echo '<tr><td><a href="calculations.php?displayr=' . $r['id'] . '&num=' . $rcount['crp'] . '">'. $r['name'] . '</a></td>';
		echo '<td><div>' . $r['description'] . '</div></td>';
		?>
			<td><a type="button" class="btn btn-primary btn-xs" class="btn btn-primary btn-lg active" role="button" href="calculations.php?displayr=<?php echo $r['id']; ?>&num=<?php echo $rcount['crp']; ?>">Виж</a></td></tr>
		<?php
		//echo '<td><a href="my_recipe.php?recipe=' . $r['id'] . '"><span class="glyphicon glyphicon-eye-open"></span></a></td></tr>';
	}
}else{
	echo "Все още нямате рецепти!";
}
?>
</table>
<?php

}else{
	header('Location: index.php');
}
require_once('template/footer.php');
