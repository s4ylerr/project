<?php 
//enters recipe details
	//temporaliry!
require_once('template/header.php');
$username = $_SESSION['user'];
require_once('functions.php');
require_once('includes.php');
if (!empty($_GET)) {
	//recipe_id
	$id_rec = $_GET['id_rec'];
	//num products
	$num = $_GET['num'];
	//recipe name
	$q = "SELECT `name` FROM `recipes` WHERE `id` = $id_rec";
	$result = mysqli_query($connect, $q);
	$row = mysqli_fetch_assoc($result);
} else {
	$id_rec= "";
	$num = "";
}
?>
<div class="row enterr" style="background-image:url('images/lines.png')";>	
	<!--Recipe name-->
	<div class="first_enterr text-center col-xs-8 col-xs-offset-2">
		<div class="row r_title">
			<div class="col-xs-8 col-xs-offset-2">
				<h2 class="rd"><?php if (isset($row['name'])) {echo $row['name'];}?></h2>
			</div>
		</div>
		<div class="row form">
			<div class="col-xs-10 col-xs-offset-1">
				<form method="post" action="enter_recipe_details.php" enctype="multipart/form-data" class="rd form-horizontal">
					<input type="hidden" name="id_rec" value="<?php echo $id_rec?>">
					<input type="hidden" name="num" value="<?php echo $num?>">
					<!--recipe products and measures-->

					<?php 
					for ($i=0; $i < $num; $i++) { 
						echo "<div class='form-group'>
						<div class='row'>
							<div class='col-xs-1'>";
								$q = "SELECT * FROM `products` ORDER BY `product`";
								$result = mysqli_query($connect, $q);
								$pr = $i+1;
								echo "<label class='rd' for='prod'".$i."'>Пр".$pr."</label></div>
								<div class='col-xs-4'>";
									echo "<select class='form-control' name='product[]' id='prod".$i."'>";
									if (mysqli_num_rows($result)>0) {
										while ($row = mysqli_fetch_assoc($result)) {	
											$product = $row['product'];
											$id_prod = $row['id'];				
											echo "<option value='$id_prod'>$product</option>";
										}
									}
									echo "</select>
								</div>
								<div class='col-xs-1'>";
									echo "<label class='rd' for='quant'>Кол</label>
								</div>
								<div class='col-xs-2'>";
									echo "<input class='form-control' type='number' name='quantity[]' id='quant'>
								</div>
								<div class='col-xs-2'>";
									$q_m = "SELECT * FROM `measures` ORDER BY `measure`";
									$result_m = mysqli_query($connect, $q_m);
									echo "<label class='rd' for='meas'".$i."'>м. ед.</label>
								</div>
								<div class='col-xs-2'>";
									echo "<select class='form-control' name='measure[]' id='meas".$i."'>";
									if (mysqli_num_rows($result_m)>0) {
										while ($row_m = mysqli_fetch_assoc($result_m)) {
											$measure = $row_m['measure'];
											$id_meas = $row_m['id'];						
											echo "<option value='$id_meas'>$measure</option>";
										}
									}
									echo "</select>
								</div>
							</div>
						</div>";
					}
					?>
					<div class="row form-group">
						<label class="rd" for="description">Начин на приготвяне на рецептата</label>
						<textarea name="description" class="form-control" id="description"></textarea>
					</div>
					<div class="row rd form-group">
						<div class="col-xs-4 col-xs-offset-1">
							<label class="rd_photo" for="ph">СНИМКА</label>
						</div>
						<div class="col-xs-4 col-xs-offset-1">
							<input type="file" name="photo" id="ph">
						</div>
					</div>
					<div class="row form-group">
						<button type="submit" name="submit" class="btn btn-primary">ЗАПИШИ</button>						
					</div>
				</form>

				<?php
				if (isset($_POST['submit'])) {
					$id_rec = $_POST['id_rec'];
					$quantity =  $_POST['quantity'];
					$measure = $_POST['measure'];
					$product = $_POST['product'];
					$description = $_POST['description'];
		//не е задължително да има снимка!!??
					if(!empty($_FILES))		{
						if (!empty($_FILES['photo']['tmp_name'])) {			
							$file_name = $_FILES['photo']['name'];
							$tmp_name = $_FILES['photo']['tmp_name'];
							$file_size = $_FILES['photo']['size'];
							$file_type = $_FILES['photo']['type'];
							$content = addslashes(file_get_contents($tmp_name));
//insering picture into the
							$q = "UPDATE `recipes` 
							SET `content_photo`='$content',
							`name_photo`='$file_name',
							`type_photo`='$file_type',
							`size_photo`='$file_size' 
							WHERE  `id` = $id_rec ";
							mysqli_query($connect, $q) or die('Error, query failed.');
						}
					}
	//num of prod
					$num = $_POST['num'];
					$flag = 0;
					$flag_des = 0;
					for ($k = 0; $k < $num; $k++) { 
				//ид продукт
						$id_prod = $product[$k];
			//ид мерна единица
						$id_meas = $measure[$k];
			//количество
						$quant = $quantity[$k];		
			//product info into the db	
						$q_r = "INSERT INTO `recipe_products_quantities`
						(`recipe_id`, `product_id`, `measures_id`, `quantity`) 
						VALUES ($id_rec, $id_prod, $id_meas, $quant)";
						if (mysqli_query($connect, $q_r)) {
							$flag = 1;
						} else {
							$flag = 0;
						}
					}
		//запис на описанието на рецептата
					$q_des = "	UPDATE `recipes` 
					SET `description`='$description'
					WHERE `id` = $id_rec ";
					if (mysqli_query($connect, $q_des)) {
						$flag_des = 1;
					} else {
						$flag_des = 0;
					}
					if ($flag == 1 && $flag_des == 1) {
						echo "Успешно записахте всички продукти и описание!<br />";
						
						echo '<a class="btn btn-info" href="calculations.php?displayr='. $id_rec .'&num='.$num.'" role="button">ПРЕГЛЕДАЙ</a>';
					} else {
						echo "Опитайте отново!";
					}
				}
				?>
			</div>		
		</div>
	</div>
</div>
<?php 
require_once('template/footer.php');