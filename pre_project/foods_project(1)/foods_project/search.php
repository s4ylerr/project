<?php 
require_once('template/header.php');
require_once('functions/shorter_text.php');
if ($_GET) {
	if ($_GET['search'] != null) {
		?>

		<div class="col-lg-12">
	    <div class="input-group">
	    <label>Търсене</label><br />
	    <form method="get" action="search.php">
	      <input name="search" type="text" class="form-control" placeholder="Search">
	      <span class="input-group-btn">
	        <button name="submit" value="search" class="btn btn-default" type="submit">Go!</button>
	      </span>
	    </form>

	      

	    </div><!-- /input-group -->
	    
	  </div><!-- /.col-lg-6 -->


		<?php
		$select_search = "SELECT *, recipes.id as recp, recipes.content_photo as rcp, recipes.date_published as dp FROM recipes 
		JOIN recipe_products_quantities ON recipes.id = recipe_products_quantities.recipe_id
		JOIN products ON recipe_products_quantities.product_id = products.id
		WHERE recipes.name LIKE '%$_GET[search]%' OR products.product LIKE '%$_GET[search]%' 
		GROUP BY recipes.name ORDER BY recipes.id DESC";

		$query_search = mysqli_query($connect, $select_search)or die(mysqli_error());
		if (mysqli_num_rows($query_search) > 0) { // проверяваме дали има намерени резултати

			$search_product = "SELECT id, content_photo, product FROM products WHERE product LIKE '$_GET[search]%'"; // търси продукт от въведената заявка след като е открило, че има някаква рецепта
			
			$qp = mysqli_query($connect, $search_product)or die(mysqli_error());

			

			echo '<p>Резултати за <b><i>'. $_GET['search'] .' - ';

			if(mysqli_num_rows($query_search) > 1){ 

				echo mysqli_num_rows($query_search) . ' резултата';
			}else{ 
				echo mysqli_num_rows($query_search) . ' резултат';
			}
			echo '</i></b></p>';
			if (mysqli_num_rows($qp) > 0) {
				echo '<div class="h3">Продукти</div>';
				while ($row_p = mysqli_fetch_assoc($qp)) {

					if ($row_p['content_photo']) {

						echo '<a href="products.php?product='. $row_p['id'] .'"><img title="'. $row_p['product'] .'" width="100" src="data:image/jpeg;base64,'.base64_encode( $row_p['content_photo'] ).'"/></a> ';
					}
				}
			}
			echo '<div class="h3">Рецепти</div>';
			while ($r = mysqli_fetch_assoc($query_search)) {
				?>
				
					<a class="rp" href="recipies.php?recipie=<?php echo $r['id_food_type']; ?>&view=<?php echo $r['recp']; ?>">
				    			<div class="rowps">
							    <table>
							    	<tr>
							    		<td><h4><?Php echo shorter($r['name'], 40); ?></h4></td>
							    	</tr>
							    	<tr>
								    	<td>
								    	<div class="hidps">
								    	<?php
								    	if ($r['rcp']) {
								    		
								    	echo '<img height="250" src="data:image/jpeg;base64,'.base64_encode( $r['rcp'] ).'"/> ';

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
							    		<td><h6><b><?php echo $r['dp']; ?></b></h6></td>
							    	</tr>
							    </table>
							    </div>
							    </a>
				<?php
			}
		}else{

			echo "Няма намерени резултати за <b><i>" . $_GET['search'] . "</i></b>";
		}

	}else{
		?>

		<div class="col-lg-12">
	    <div class="input-group">
	    <label>Опитайте различно търсене</label><br />
	    <form method="get" action="search.php">
	      <input name="search" type="text" class="form-control" placeholder="Search">
	      <span class="input-group-btn">
	        <button name="submit" value="search" class="btn btn-default" type="submit">Go!</button>
	      </span>
	    </form>

	      

	    </div><!-- /input-group -->
	    
	  </div><!-- /.col-lg-6 -->

		<?php
	}
}else{
	?>

		<div class="col-lg-12">
	    <div class="input-group">
	    <label>Търсене</label><br />
	    <form method="get" action="search.php">
	      <input name="search" type="text" class="form-control" placeholder="Search">
	      <span class="input-group-btn">
	        <button name="submit" value="search" class="btn btn-default" type="submit">Go!</button>
	      </span>
	    </form>	
	      </div><!-- /input-group -->
	    
	  </div><!-- /.col-lg-6 -->

	<?php
}

require_once('template/footer.php');