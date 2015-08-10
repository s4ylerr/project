<?php
	require_once('template/header.php');
	require_once('functions/shorter_text.php');

	?>

	<div class="row">
			<div class="col-md-12 just">
				<div class="first text-center col-xs-12">
					<div class="row">
						<div class="newclas col-xs-12">						

						
						<!--                започва менюто			-->

							<ul class="nav nav-tabs">
							

								<?php

									$select_categories_article = "SELECT * FROM categories_article"; // избирам всички категории от блога

									$query = mysqli_query($connect, $select_categories_article)or die(mysqli_error()); // пускам заявката

									if (mysqli_num_rows($query) >0) { // проверявам дали има повече от 0 записа

										while ($r = mysqli_fetch_assoc($query)) { // обхождам всички записи на категориите от блога
											
											if ($_GET) {

												$get_id = $_GET['category'];

												if ($get_id == $r['id_category']) {

													echo '<li class="active" role="presentation"><a href="?category='. $r['id_category'] .'">' . $r['category'] . '</a></li>';
													
												}else{

													echo '<li role="presentation"><a href="?category='. $r['id_category'] .'">' . $r['category'] . '</a></li>';
												}
												

											}else{

													echo '<li role="presentation"><a href="?category='. $r['id_category'] .'">' . $r['category'] . '</a></li>';

												}
											

										}

									}

								?>

							</ul>
						<!--                край на  менюто			-->


						</div>
					</div>
				</div>
			</div>
		</div>
		

<?php

if ($_GET) {
if (!isset($_GET['article'])){ 

	$category = $_GET['category'];

	$query_categories = "SELECT * FROM articles WHERE id_category = '$category'";

	$sql_article = mysqli_query($connect, $query_categories)or die(mysqli_error());

	if (mysqli_num_rows($sql_article) > 0) {
		while ($r = mysqli_fetch_assoc($sql_article)) {
			
			
			?>
			<div class="categories_article">
			
			        <h3><a href="?category=<?php echo $_GET['category']; ?>&article=<?php echo $r['id_article']; ?>"><?php  echo $r['title_article']; ?></a></h3>
			       <?php echo shorter($r['text_article'], 150); ?>
			</div>


			<?php

		}
	}else{

		echo 'Вижте другите категории';

	}
}
	//echo '<div style="clear: both;"></div>';


	// опит за изкарване на статия
	if (isset($_GET['article'])){

		$article_id = $_GET['article'];

		$select_one_article = "SELECT * FROM articles WHERE id_article = '$article_id'";

		$q = mysqli_query($connect, $select_one_article)or die(mysqli_error());
		$r = mysqli_fetch_assoc($q);

		echo '<h3>' . $r['title_article'] . '</h3>';
		echo '<div class="article">';
		echo '<span class="glyphicon glyphicon-calendar"> '. $r['date_article'] .' </span> ';
		echo ' <span class="glyphicon glyphicon-eye-open"> 5 </span> ';
		echo ' <span class="glyphicon glyphicon-comment"> 1 </span> <br/>';
		echo $r['text_article'];
		echo '</div>';
	}
	}else{

	$select_all_articles = "SELECT * FROM articles"; // избирам всички статии, когато не е избрана определена категория

	$query_articles = mysqli_query($connect, $select_all_articles)or die(mysqli_error());



}

	require_once('template/footer.php');
?>


									  
									