<?php
    require_once('template/header.php');
	require_once('functions/shorter_text.php');
?>
<div class="row">
<div class="left col-md-8">
		   <div id="sliderFrame">
	        <div id="slider">
            <?php
                $select_rec = "SELECT * FROM recipes WHERE size_photo > 0 AND `recipes`.`date_deleted` IS NULL ORDER BY id DESC LIMIT 4 ";
                $query_rec = mysqli_query($connect, $select_rec)or die(mysqli_error());
                if (mysqli_num_rows($query_rec) > 0) {
                    while ($r = mysqli_fetch_assoc($query_rec)) {
                        echo '<a href="recipies.php?recipie='. $r['id_food_type'] .'&view='. $r['id'] .'">';
                            echo '<img src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'" alt="'. $r['name'] .'" />';
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
    
</div>
<div class="left col-md-4">
<h3 class="h3">Последни рецепти</h3>
    <ul class="list-unstyled">
<?php

    $select_last_five_recipe = "SELECT * FROM recipes WHERE `recipes`.`date_deleted` IS NULL ORDER BY id DESC LIMIT 5";
    $row_five_recipes = mysqli_query($connect, $select_last_five_recipe)or die(mysqli_error());
    if (mysqli_num_rows($row_five_recipes) > 0) {
        while ($r = mysqli_fetch_assoc($row_five_recipes)) {
            
            echo '<li><a href="recipies.php?recipie='. $r['id_food_type'] .'&view='. $r['id'] .'"><h4>';
            if ($r['content_photo']) {
                echo '<img width="50" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'"/> ';
            }else{
                echo '<img width="50" src="images/default-placeholder.png" />';
            }
            //<h4>h4. Bootstrap heading <small>Secondary text</small></h4>
            echo '&nbsp;&nbsp;' . $r['name'] . '</h4></a></li>';
        }
    }

?>
</ul>
</div>
</div>
<div class="row">
<div class="h3"></div>

    <div class="left col-md-6">
    <h3 class="h3">От блога</h3>
    <?php
        $select_last_article = "SELECT * FROM articles ORDER BY id_article DESC LIMIT 1";
        $query_last_article = mysqli_query($connect, $select_last_article)or die(mysqli_error());
        $row_last_article = mysqli_fetch_assoc($query_last_article);
        echo '<h3><a href="blog.php?category='. $row_last_article['id_category'] .'&article='. $row_last_article['id_article'] .'">'. $row_last_article['title_article'] .'</a></h3>';
        echo shorter($row_last_article['text_article'], 1500);
    ?>

    <p><a type="button" class="btn btn-primary btn-xs" class="btn btn-primary btn-lg active" role="button" href="blog.php?category=<?php echo $row_last_article['id_category']; ?>&article=<?php echo $row_last_article['id_article']; ?>">Прочети повече</a></p>
    
    </div>
    <div class="left col-md-6">
        <h3 class="h3">Последни продукти</h3>
        <?php
            $select_last_added_product = "SELECT * FROM products WHERE content_photo IS NOT NULL AND date_deleted IS NULL ORDER BY id DESC LIMIT 6";
            $query_last_added_product = mysqli_query($connect, $select_last_added_product)or die(mysqli_error());
            if (mysqli_num_rows($query_last_added_product) > 0) {
                while ($r = mysqli_fetch_assoc($query_last_added_product)) {
                    echo '<a href="products.php?product='. $r['id'] .'">';
                    echo '<div class="products">';
                    echo '<img width="120" src="data:image/jpeg;base64,'.base64_encode( $r['content_photo'] ).'"/><br />';
                    echo '<span class="h4">' . $r['product'] . '</span>';
                    echo '</div>';
                    echo '</a>';

                }
            }

        ?>
        <div class="clear"></div>
    </div>
</div>

<?php
	require_once('template/footer.php');
?>