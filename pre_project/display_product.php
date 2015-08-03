<?php 
header('Content-Type: text/html; charset=utf-8'); 
require_once('functions.php');
require_once('includes.php');
//change  `recipes`.`id`= 7
$recipe = array(array());
$i = 0;
$q = "SELECT * FROM `products`
JOIN `users` ON  `products`.`user_id` = `users`.`id`
WHERE `products`.`id`= 100"; 
$res = mysqli_query($connect, $q);
$row = mysqli_fetch_assoc($res);

echo "<p> Информация за ".$row['product']."</p>
<p>Калории/100 гр - ".$row['calories']."</p>
<p>Гликемичен индекс/100гр - ".$row['gi']."</p>
<p>публикувана от ".$row['username']." на ".$row['date_published']."</p>";
//снимка ако има
if (!empty($row['content_photo'])) {
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';
}



	?>