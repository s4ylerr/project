<?php 
//enters recipe name and number of products	
	//temporaliry!
require_once('template/header.php');
$username = $_SESSION['user'];
require_once('functions.php');
require_once('includes.php');
if (!empty($_GET)) {
	$id_rec = $_GET['updaterd'];
	$num = $_GET['num'];
	//данните, вече въведени за описанието на рецептата и нейните продукти и за евентуална промяна
	$q = "SELECT * FROM `recipes` WHERE `id` = $id_rec";
	$result = mysqli_query($connect, $q);
	$row_rec = mysqli_fetch_assoc($result);
//	 и нейните продукти и за евентуална промяна
	$prod_info = array(array());
	$q_prod = "SELECT * FROM `recipe_products_quantities` WHERE `recipe_id` = $id_rec ORDER BY `id`";
	$res_prod = mysqli_query($connect, $q_prod);
	$i = 0;
	if (mysqli_num_rows($res_prod) > 0) {
		while($row_prod = mysqli_fetch_assoc($res_prod)) {
			foreach ($row_prod as $key => $value) {
				$prod_info[$i][$key] = $value;
			}
			$i++;			
		}
	}
} else {
	$id_rec = "";
	$num = "";
}
/*echo "<pre>";
var_dump($prod_info);
echo "</pre>";*/
?>
<div class="row enterr" style="background-image:url('images/lines.png')";>	
	<!--Recipe name-->
	<div class="first_enterr text-center  col-xs-8 col-xs-offset-2">
		<div class="row r_title">
			<div class="col-xs-8 col-xs-offset-2">
				<h2><?php if (isset($row_rec['name'])) {echo $row_rec['name'];}?></h2>
			</div>
		</div>
		<div class="row form">
			<div class="col-xs-10 col-xs-offset-1">
				<form method="post" action="" enctype="multipart/form-data" class="rd form-horizontal">
					<input type="hidden" name="id_rec" value="<?php echo $id_rec; ?>">
					<input type="hidden" name="num_prod" value="<?php echo $num;?>">
					<input type="hidden" name="id" value=<?php if (isset($prod_info[0]['id'])) {echo $prod_info[0]['id'];}?>>
					<!--recipe products and measures-->
					<?php 
					for ($j=0; $j < $num; $j++) { 
			//echo $j.' ';
			//echo $prod_info[$j]['product_id'].' ';
						echo "<div class='form-group'>
						<div class='row'>
							<div class='col-xs-1'>";
								$q = "SELECT * FROM `products` ORDER BY `product` ";
								$result = mysqli_query($connect, $q);
								$pr = $j+1;
								echo "<p><label class='rd' for='prod'".$j."'>Пр".$pr."</label>
							</div>
							<div class='col-xs-4'>";
									echo "<select class='form-control' name='product[]' id='prod".$j."'>";			//echo $j.' ';
									echo $prod_info[$j]['product_id'].' ';
									if (mysqli_num_rows($result)>0) {
										while ($row = mysqli_fetch_assoc($result)) {	
											$product = $row['product'];
											$prod_id = $row['id'];				
											echo "<option value='$prod_id'";
					//echo $j;
											echo $prod_info[$j]['product_id'];
											if ($prod_id == $prod_info[$j]['product_id']) {
												echo " selected";
											} else {
												echo "";
											}
											echo ">".$product."</option>";
										}
									}
									echo "</select></p>";
									$quantity = $prod_info[$j]['quantity'];
									echo "</div>
									<div class='col-xs-1'>";
										echo "<label class='rd' for='quant'>Кол </label>
									</div>
									<div class='col-xs-2'>";
										echo "<input class='form-control' type='number' name='quantity[]' value = '$quantity'>
									</div>
									<div class='col-xs-2'>";
										$q_m = "SELECT * FROM `measures` ORDER BY `measure`";
										$result_m = mysqli_query($connect, $q_m);
										echo "<label class='rd'  for='meas'".$j."'>м. ед.</label>
									</div>
									<div class='col-xs-2'>";
										echo "<select class='form-control' name='measure[]' id='meas".$j."'>";
										if (mysqli_num_rows($result_m)>0) {
											while ($row_m = mysqli_fetch_assoc($result_m)) {
												$measure = $row_m['measure'];
												$meas_id = $row_m['id'];						
												echo "<option value='$meas_id'";
												if ($prod_info[$j]['measures_id'] == $meas_id) {
													echo " selected";
												}
												echo ">".$measure."</option>";
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
							<textarea name="description" class="form-control" id="description" value="<?php echo $row_rec['description']; ?>">
								<?php  if (isset ($row_rec['description'])){ echo $row_rec['description']; }?>
							</textarea>
						</div>
						<div class="row">
							<div class="col-xs-6 col-xs-offset-3">
								<button type="submit" name="submit" class="btn btn-primary">ЗАПИШИ</button>	
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6 col-xs-offset-3">
								<a href="calculations.php?displayr=<?php echo $_GET['updaterd']; ?>&num=<?php echo $_GET['num']; ?>" class="btn btn-info active" role="button">ПРЕГЛЕДАЙ</a>					
							</div>
						</div>
					</form>
					<?php
					if (isset($_POST['submit'])) {
		//трябва ли ми???
						$id_rec = $_POST['id_rec'];
						$id = $_POST['id'];
						$quantity =  $_POST['quantity'];
						$measure = $_POST['measure'];
						$p = $_POST['product'];
						$description = $_POST['description'];
	//num of prod
						$num = $_POST['num_prod'];
		//updating photo
		//не е задължително да има снимка
						if(!empty($_FILES))		{			
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
	//update product info
						$flag = 0;
						$flag_des = 0;
						for ($k = 0; $k < $num; $k++) { 
				/*echo $p[$k]." ";
				echo $measure[$k]." ";
				echo $quantity[$k]."<br /> ";*/
				$q_r = "UPDATE `recipe_products_quantities` 
				SET `quantity`= $quantity[$k],
				`product_id` = $p[$k],
				`measures_id` = $measure[$k]
				WHERE `id`=$id";
				if (mysqli_query($connect, $q_r)) {
					$flag = 1;
				} else {
					$flag = 0;
				}
				$id++;
			}
		//запис на описанието на рецептата
			$q_des = "UPDATE `recipes` 
			SET `description`='$description'
			WHERE `id` = $id_rec";
			if (mysqli_query($connect, $q_des)) {
				$flag_des = 1;
			} else {
				$flag_des = 0;
			}
			if ($flag == 1 && $flag_des == 1) {
				echo "<div class'row'><div class='col-xs-8 col-xs-offset-2'><p class='bg-info text-primary'>Успешно записахте всички продукти и описание!</p></div></div>";
				
			} else {
				echo "<div class'row'><div class='col-xs-8 col-xs-offset-2'><p class='bg-danger text-danger'>Опитайте отново!</p></div></div>";

			}
			
		}
		?>
		<div>
			<?php 
			$q = "SELECT `content_photo` FROM `recipes` WHERE id = $id_rec";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);
			echo '<img class="img-thumbnail img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';
			?>
		</div>
		<div class="row">
			<div class="col-xs-4 col-xs-offset-4">
				<a class="btn btn-info" href="update_photo_recipe.php?id_rec=<?php echo $id_rec?>&num=<?php echo $_GET['num']; ?>" role="button">ПРОМЕНИ СНИМКА</a>
			</div>
		</div>
	</div>
</div>
</div>
<?php
require_once('template/footer.php');