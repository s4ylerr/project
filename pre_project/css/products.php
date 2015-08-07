<?php
require_once('template/header.php');
echo $_GET['product'];
	
	echo '<h3>' . $r['title_article'] . '</h3>';
	echo '<div class="article">';
	echo '<span class="glyphicon glyphicon-calendar"> '. $r['date_article'] .' </span> ';
	echo ' <span class="glyphicon glyphicon-eye-open"> 5 </span> ';
	echo ' <span class="glyphicon glyphicon-comment"> 1 </span> <br/>';
	echo $r['text_article'];
	echo '</div>';
require_once('template/footer.php');