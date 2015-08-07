<?php
require_once('template/header.php');
if ($_SESSION) {


$select_id_user = "SELECT id FROM users WHERE username = '$_SESSION[user]'";
$query_id_user = mysqli_query($connect, $select_id_user)or die(mysqli_error());
$fetch_row = mysqli_fetch_assoc($query_id_user);

$my_recipe = "SELECT * FROM recipes WHERE user_id = '$fetch_row[id]' AND date_deleted IS NULL";
$query_recipe = mysqli_query($connect, $my_recipe)or die(mysqli_error());
echo "<br /><a class='btn btn-success btn-sm active' role='button' href='enter_recipe.php'>Добави рецепта</a><br /><br />";
?>
	<table class="table table-bordered">
		  <tr><td class="title" colspan="3"><b>ВСИЧКИ РЕЦЕПТИ</b></td></tr>
		  <tr><td><b>Име</b></td><td><b>Описание</b></td><td><b>Преглед</b></td></tr>
<?php
if (mysqli_num_rows($query_recipe)>0) {
	while ($r = mysqli_fetch_assoc($query_recipe)) {
		echo '<tr><td><a href="my_recipe.php?recipe=' . $r['id'] . '">'. $r['name'] . '</a></td>';
		echo '<td><div>' . $r['description'] . '</div></td>';
		?>
			<td><a type="button" class="btn btn-primary btn-xs" class="btn btn-primary btn-lg active" role="button" href="my_recipe.php?recipe=<?php echo $r['id']; ?>">Виж</a></td></tr>
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
