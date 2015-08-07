<?php
	require_once('template/header.php');
	require_once('functions/queries.php');
	require_once('functions/shorter_text.php');
	
	?>

<div class="row">
	<!--                започва менюто			-->

		<div class="left col-md-3">
			<ul class="list-group">
		<?php


		$q = "SELECT *, COUNT(`recipes`.`id`) as `count_rep` FROM food_types LEFT JOIN recipes ON food_types.id_food = recipes.id_food_type WHERE `recipes`.`date_deleted` IS NULL GROUP BY food_types.food_type";
		$r = queries($connect, $q);
		
		if(mysqli_num_rows($r) > 0){
			while ($row = mysqli_fetch_assoc($r)) {
				if (isset($_GET['recipie'])) {
						if ($_GET['recipie'] == $row['id_food_type']) {
							?>
							<a href="?recipie=<?php echo $row['id_food']; ?>">
			  					<li class="list-group-item active">
			  					<span class="badge"><?php echo $row['count_rep']; ?></span>
			  					<?php
			  						echo $row['food_type'];
			  					?>
			  					</li>
			  				</a>
							<?php
						}else{
						
							?>
								<a href="?recipie=<?php echo $row['id_food']; ?>">
					  				<li class="list-group-item">
					  				<span class="badge"><?php echo $row['count_rep']; ?></span>
					  				<?php
				  						echo $row['food_type'];
				  					?>
					  				</li>
				  				</a>
							<?php

						}	
					
				}else{
					?>
					<a href="?recipie=<?php echo $row['id_food']; ?>">
		  				<li class="list-group-item">
				
				<span class="badge"><?php echo $row['count_rep']; ?></span>
		    		
				<?php
				echo $row['food_type'];
				}
				?>
						</li>
	  				</a>
				<?php
				
			}
		}

		?>
		  
		  
		</ul>
</div>
<div class="left col-md-9">
	<?php
	if ($_GET) {
		if (isset($_GET['view'])) {
			
			$select_one_recipes = "SELECT * FROM recipes WHERE id = '$_GET[view]' AND `recipes`.`date_deleted` IS NULL";

			$q = queries($connect, $select_one_recipes);

			$r = mysqli_fetch_assoc($q);

			?>

				<div class="row">
					<div class="left col-md-7">
						<?php
						echo '<h3 class="h3">'. $r['name'] .'</h3>';
						
						if ($r['content_photo']) {
							echo '<img class="max_img_recipe" max-width="450" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'"/> ';	
						}
						echo '<h5>НАЧИН НА ПРИГОТВЯНЕ</h5>';
						echo '<div>';
							echo $r['description'];
						echo '</div>';
						?>
					</div>
					<div class="left col-md-5">
					<h3 class="h3">необходими продукти</h3>
						<table class="table table-bordered">
						 	<tr><td><b>Продукт</b></td><td colspan="2"><b>Калории</b></td></tr>


						 		<?php
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			///////////////// ЗАЯВКАТА И ПРИНТИРАНЕТО НА ПРОДУКТИТЕ ЗА РЕЦЕПТАТА //////////////////////////////
						 		
						 			$select_products = "SELECT *, products.id as p FROM recipe_products_quantities 
						 			LEFT JOIN products ON recipe_products_quantities.product_id = products.id
						 			LEFT JOIN measures ON recipe_products_quantities.measures_id = measures.id
						 			LEFT JOIN recipes ON recipe_products_quantities.recipe_id = recipes.id
						 			WHERE recipe_id = '$_GET[view]' AND `recipes`.`date_deleted` IS NULL ORDER BY recipe_products_quantities.id ASC"; // това е заявката с която изкарвам всичката информация за една рецепта
						 			$cal = 0;
						 			$quant = 0;
						 			$query = mysqli_query($connect, $select_products)or die(mysqli_error());
						 			if (mysqli_num_rows($query) > 0) {
						 				while ($result = mysqli_fetch_assoc($query)) {
						 					$quant = $quant + $result['quantity'];
						 					echo '<tr><td>' . $result['quantity'] . ' ' . $result['measure'] . ' 
						 					<a href="products.php?product='. $result['p'] .'">' . $result['product'] . '</td><td colspan="2">' . $result['calories']/100*$result['quantity'] . '
						 					 kcal</td></tr>';
						 					$cal = $cal + $result['calories']/100*$result['quantity']; // изчислявам калориите
						 				}
						 			}
						 			
						 			

						 		?>
						 		<tr><td><b>Общо калории / гр</b></td><td><b><?php echo round($cal); ?> kcal</td><td><b><?php echo $quant ?> гр</td></b></td></tr>
						 		<tr><td><b>Калории / за 100 гр</b></td><td><b><?php echo round($cal/$quant*100); ?> kcal</td><td><b>100 гр</b></td></tr>
						 		<?php
						 		if ($r['portion'] > 0) {
						 			?>
						 				<tr><td><b>Порции</b></td><td><b><?php echo $r['portion']; ?><?php echo round($cal/$r['portion']); ?> kcal</b></td></tr>
						 			<?php
						 		}
						 		?>
						 		
						 		<tr><td><b>Гликемичен индекс</b></td><td colspan="2"><b><?php echo $r['gi_recipe']; ?> (ГИ)</b></td></tr>
						</table>
						<?php
							$sel_user = "SELECT *, COUNT(recipes.user_id) as coun FROM users 
							LEFT JOIN user_info ON users.id = user_info.id_user
							LEFT JOIN recipes ON users.id = recipes.user_id
							WHERE users.id = '$r[user_id]' AND `recipes`.`date_deleted` IS NULL";
							
							$query_user = mysqli_query($connect, $sel_user)or die(mysqli_error());
							$row_user = mysqli_fetch_assoc($query_user);
						?>
						<table class="table">
							<tr>
								<?php
									if ($row_user['profile_picture']) {
										
									
								?>
									<td rowspan="3"><?php echo '<img width="50" src="data:image/jpeg;base64,'.base64_encode( $row_user['profile_picture'] ).'"/> '; ?></td>
									
								<?php
									}else{
										?>

										<td rowspan="3"><img width="100" src="images/profile.jpg"></td>

										<?php
									}
								?>

									<td><h6>автор на рецепта:</h6></td>
									
								
								<tr>
									<td><b><?php echo $row_user['username']; ?></b></td>
								</tr>
								<tr>
									<td colspan="2">
										<?php echo $row_user['info_user']; ?>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<a href="#">Рецепти <span class="badge active"><?php echo $row_user['coun']; ?></span></a><br />
										<?php
											$count_article = "SELECT COUNT(*) as c FROM articles WHERE id_user = '$r[user_id]'";
											$query_count = mysqli_query($connect, $count_article)or die(mysqli_error());
											$r_count = mysqli_fetch_assoc($query_count);
										?>
										<a href="#">Блог пост <span class="badge"><?php echo $r_count['c']; ?></span></a><br />
									</td>
								</tr>
							</tr>
						</table>
					</div>
				</div>

			<?php
			
		}elseif($_GET['recipie']) {
			
			$select_all_recipes = "SELECT * FROM recipes WHERE id_food_type = '$_GET[recipie]' AND `recipes`.`date_deleted` IS NULL ORDER BY id DESC";

			$r = queries($connect, $select_all_recipes);

			

			$select_food_type = "SELECT food_type FROM food_types WHERE id_food = '$_GET[recipie]'";

			$query_food_type = mysqli_query($connect, $select_food_type)or die(mysqli_error());

			$food_type = mysqli_fetch_assoc($query_food_type);
			
			echo '<p><h3 class="h3">' . $food_type['food_type'] . '</h3></p>';

			if (mysqli_num_rows($r) >0) {
				while ($row = mysqli_fetch_assoc($r)) {
				?>
					
				
					<a class="rp" href="recipies.php?recipie=<?php echo $row['id_food_type']; ?>&view=<?php echo $row['id']; ?>">
		    			<div class="rowps">
						    <table>
						    	<tr>
						    		<td><h4><?Php echo shorter($row['name'], 40); ?></h4></td>
						    	</tr>
						    	<tr>
							    	<td>
							    	<div class="hidps">
							    	<?php
							    	if ($row['content_photo']) {
							    		
							    	echo '<img height="250" src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/> ';

							    }else{ 
							    	?>
							    		<img width="250" src="images/default-placeholder.png" />	
							    	<?php
							    	}
							    	?>
							    	</div>
							    	</td>
						    	</tr>
						    	<tr>
						    		<td><h6><b><?php echo $row['date_published']; ?></b></h6></td>
						    	</tr>
						    </table>
					    </div>
					</a>

				<?php
				}
			}
		}
	}else{

		$select_all_recipes = "SELECT * FROM recipes WHERE `recipes`.`date_deleted` IS NULL";
			$r = queries($connect, $select_all_recipes);
			echo '<p><h3 class="h3">Всички рецепти</h3></p>';
			if (mysqli_num_rows($r) >0) {
				//while ($row = mysqli_fetch_assoc($r)) {

/////////////////////////////  започва общия слайдер, когато не е избран никакъв тип рецепта ////////////////////////////////

					?>

					<div id="sliderFrame">
					        <div id="slider">
				            <?php
				                $select_rec = "SELECT * FROM recipes WHERE size_photo > 0  AND `recipes`.`date_deleted` IS NULL ORDER BY id DESC LIMIT 4"; // взима последните добавени рецепти със снимка
				                $query_rec = mysqli_query($connect, $select_rec)or die(mysqli_error());
				                if (mysqli_num_rows($query_rec) > 0) {
				                    while ($r = mysqli_fetch_assoc($query_rec)) {
				                        echo '<a href="recipies.php?recipie='. $r['id_food_type'] .'&view='. $r['id'] .'">';
				                            echo '<img class="max_img_recipe" width="500" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'" alt="'. $r['name'] .'" />';
				                        echo '</a>';
				                    }
				                }
				            ?>
					        </div>
				        <!--thumbnails-->
				        <div id="thumbs">
				        <?php
				            $select_recipe = "SELECT * FROM recipes WHERE size_photo > 0 AND `recipes`.`date_deleted` IS NULL ORDER BY id DESC LIMIT 4 ";
				            $query_recipe = mysqli_query($connect, $select_recipe)or die(mysqli_error());
				            if (mysqli_num_rows($query_recipe) > 0) {
				                    while ($row = mysqli_fetch_assoc($query_recipe)) {
				                        echo '<div class="thumb">';
				                        echo     '<div class="frame"><img src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'" /></div>';
				                        echo     '<div class="thumb-content"><p>'. $row['name'] .'</p>'. shorter($row['description'], 20) .'</div>';
				                        echo     '<div style="clear:both;"></div>';
				                        echo '</div>';
				                    }
				                }
				        ?>
				        </div>
				        <!--clear above float:left elements. It is required if above #slider is styled as float:left. -->
				        <div style="clear:both;height:0;"></div>
				    </div>
				    
				    <?php
				    	$sel_all_recipes = "SELECT * FROM recipes WHERE `recipes`.`date_deleted` IS NULL ORDER BY id DESC";
				    	$q = mysqli_query($connect, $sel_all_recipes)or die(mysqli_error());
				    	if (mysqli_num_rows($q) > 0) {
				    		while ($r = mysqli_fetch_assoc($q)) {
				    			?>
				    			<a class="rp" href="recipies.php?recipie=<?php echo $r['id_food_type']; ?>&view=<?php echo $r['id']; ?>">
				    			<div class="rowps">
							    <table>
							    	<tr>
							    		<td><h4><?Php echo shorter($r['name'], 40); ?></h4></td>
							    	</tr>
							    	<tr>
								    	<td>
								    	<div class="hidps">
								    	<?php
								    	if ($r['content_photo']) {
								    		
								    	echo '<img height="250" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'"/> ';

								    }else{ 
								    	?>
								    		<img width="250" src="images/default-placeholder.png" />	
								    	<?php
								    	}
								    	?>
								    	</div>
								    	</td>
							    	</tr>
							    	<tr>
							    		<td><h6><b><?php echo $r['date_published']; ?></b></h6></td>
							    	</tr>
							    </table>
							    </div>
							    </a>
				    			<?php
				    		}
				    	}
				    ?>
				    
				    <div class="clear"></div>
					<?php
					/////////////////////////////  свършва слайдера ////////////////////////////////////////
				//}
			}

	}
	?>
</div>
</div>
	<!--                край на  менюто			-->

	<?php

	require_once('template/footer.php');
?>