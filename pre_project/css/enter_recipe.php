	<?php 
//enters recipe name and number of products	
	//temporaliry!
	require_once('template/header.php');
	require_once('functions.php');
	require_once('includes.php');
	$username = $_SESSION['user'];
	?>	
	<div class="row enterr" style="background-image:url('images/lines.png')";>	
		<div class="col-xs-12 just">
			<div class="first_enterr text-center col-xs-8 col-xs-offset-2">
				<p><h3>Въведете данни за Вашата рецепта</h3></p>
				<div class="row">
					<div class="col-xs-10 col-xs-offset-1">
						<form method="post" action="enter_recipe.php" class="form-horizontal">
							<div class="form-group ">
								<label for="name">Заглавие на Вашата рецепта</label>
								<input type="text" name="name" id="name" class="form-control">
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-6">
										<?php 
										$q_f = "SELECT * FROM `food_types` ORDER BY `food_type`";

										echo "<label for='f_t'>ТИП ЯСТИЕ</label>";
										echo "</div>
										<div class='col-xs-6'>";

											echo "<select name='id_food' id='f_t' class='form-control'>";
											$result_f = mysqli_query($connect, $q_f);
											if (mysqli_num_rows($result_f)>0) {
												while ($row_f = mysqli_fetch_assoc($result_f)) {
													$food_type = $row_f['food_type'];
													$id_food = $row_f['id_food'];						
													echo "<option value='$id_food'>$food_type</option>";
												}
											}
											echo "</select></div>";

											?>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-xs-10">
												<label for="num">Въведете брой на продуктите, участващи в рецептата</label>
											</div>
											<div class="col-xs-2">
												<input type="number" name="num" id="num" class="form-control">	
											</div>
										</div>
										<div class="form-group">
											<button type="submit" name="submit" class="btn btn-primary">ВЪВЕДИ</button>
										</div>
									</form>
									<?php 
									if (isset($_POST['submit'])) {
										$num = $_POST['num'];
										$name = $_POST['name'];
										$id_food = $_POST['id_food'];

										$date = date('Y-m-d');
										$id_user = "";

		//getting the id of the user !!! from sessions username!!!!
										$q = "SELECT * FROM `users` WHERE `username` = '$username'";
										$result = mysqli_query($connect, $q);
										$row = mysqli_fetch_assoc($result);	
										$id_user= $row['id'];
		//entering recipe into database
										$q_r = "INSERT INTO `recipes`(`name`, `id_food_type`, `date_published`, `user_id`)
										VALUES ('$name', $id_food,'$date','$id_user')";
										if (mysqli_query($connect, $q_r)) {
											$q = "SELECT `id` FROM `recipes` WHERE `name` = '$name'";
											$result = mysqli_query($connect, $q);
											$row = mysqli_fetch_assoc($result);
					//recipe id
											$id_rec = $row['id'];
											echo "<div class'row'><div clas='col-xs-12'><h3 class='bg-info text-info'><em>".$name."</em></h3></div></div>";
											echo "<div class'row'><div clas='col-xs-12'>Рецептата съдържа <strong>".$num." продукта</strong></div></div>";

			//промени или изтрий името
											echo "<div class'row'><div clas='col-xs-12'><a class='btn btn-success' href='enter_recipe_details.php?id_rec=$id_rec&num=$num' role='button'>Премини нататък</a></div></div>";

										} else {
											
											echo "<div class'row'><div class='col-xs-8 col-xs-offset-2'><p class='bg-danger text-danger'>Моля, опитайте отново!</p></div></div>";
										}			
									} else {
						//echo "Моля, попълнете информацията за рeцептата!";
									}
									?>


									<div class="row">
									<div class="col-xs-6">
											<a class="btn btn-danger" href="delete_recipe.php?id_rec=<?php echo $id_rec?>" role="button">Изтрий</a>
										</div>
										<div class="col-xs-6">
											<a class="btn btn-info" href="update_recipe.php?id_rec=<?php echo $id_rec?>&num=<?php echo $num; ?>" role="button">Промени</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>


		<?php
		require_once('template/footer.php');