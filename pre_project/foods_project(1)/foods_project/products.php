<?php
require_once('template/header.php');

require_once('functions/shorter_text.php');
if ($_GET) {

	$_GET['product'];
	$sel_product = "SELECT *, users.username as u FROM products 
	LEFT JOIN users ON products.id_user = users.id
	WHERE products.id = '$_GET[product]' AND products.date_deleted IS NULL";
	$q = mysqli_query($connect, $sel_product)or die(mysqli_error());
	$r = mysqli_fetch_assoc($q);
	
	?>

		<div class="row">
			<div class="left col-md-4">
				<h3 class="h3"><?php echo $r['product']; ?></h3>
				<div class="row">
					<div style="text-align: left;" class="left col-md-6">
						<span class="glyphicon glyphicon-calendar"><?php echo $r['date_published']; ?></span> 
					</div>
					<div style="text-align: right;" class="left col-md-6">
						<span class='glyphicon glyphicon-user'><?php echo $r['u']; ?></span>
					</div>
				</div>
				<br />
				
				<?php
					if ($r['content_photo']) {
							echo '<img title="'. $r['product'] .'" class="max_img_recipe" width="350" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'"/> ';	
						}
				?>
				<div class="product_text">
					<?php echo $r['description']; ?>
				</div>
			</div>
			<div class="left col-md-2">
				<table class="table table-bordered">
					<tr><td colspan="2"><b>За 100 гр продукт</b></td></tr>
					<tr>
						<td>Калории</td><td><?php echo $r['calories'] ?> kcal</td>
						
					</tr>
					<tr>
						<td>Гликемичен индекс</td><td><?php echo $r['gi'] ?> (ГИ)</td>
					</tr>
				</table>
			</div>
			<div class="left col-md-6">
				<h3 class="h3">Рецепти с <?php echo $r['product']; ?></h3>

				<?php 

				$sel_rec_prod = "SELECT *, `recipes`.`id_food_type` as rp_id_ft, `recipes`.`date_published` as rp_dp, `recipes`.`name` as rp_name, 
				`recipes`.`id` as rp_id, `recipes`.`content_photo` as rp_cp
				 FROM `recipe_products_quantities`
				  LEFT JOIN `products` ON `recipe_products_quantities`.`product_id` = `products`.`id` 
				  LEFT JOIN `recipes` ON `recipe_products_quantities`.`recipe_id` = `recipes`.`id` 
				  WHERE `products`.`id` = '$_GET[product]' ORDER BY `recipes`.`id` DESC LIMIT 10 ";
				$query_rec = mysqli_query($connect, $sel_rec_prod)or die(mysqli_error());
				if (mysqli_num_rows($query_rec) > 0) {
					while ($row = mysqli_fetch_assoc($query_rec)) {
						
					
				
				?>



					<a class="rp" href="recipies.php?recipie=<?php echo $row['rp_id_ft']; ?>&view=<?php echo $row['rp_id']; ?>">
		    			<div class="rowps">
						    <table>
						    	<tr>
						    		<td><h4><?php echo shorter($row['rp_name'], 40); ?></h4></td>
						    	</tr>
						    	<tr>
							    	<td>
							    	<div class="hidps">
							    	<?php
							    	if ($row['rp_cp']) {
							    		
							    	echo '<img title="'.$row['rp_name'].'" height="250" src="data:image/jpeg;base64,'.base64_encode( $row['rp_cp'] ).'"/> ';

							    }else{ 
							    	?>
							    		<img  title="<?php echo $row['rp_name'];  ?>" width="250" src="images/default-placeholder.png" />	
							    	<?php
							    	}
							    	?>
							    	</div>
							    	</td>
						    	</tr>
						    	<tr>
						    		<td><h6><b><?php echo $row['rp_dp']; ?></b></h6></td>
						    	</tr>
						    </table>
					    </div>
					</a>
					<?php

					}	
					}				
					?>

			</div>
		</div>

	<?php
}

require_once('template/footer.php');