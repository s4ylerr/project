<?php 
header('Content-Type: text/html; charset=utf-8'); 
require_once('functions.php');
require_once('includes.php');
if (!empty($_GET)) {
	$id = $_GET['id'];
	$q = "SELECT `content_photo` FROM `products` WHERE id = $id";
	$result = mysqli_query($connect, $q);
	$row = mysqli_fetch_assoc($result);
	echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';
} else {
	$id = " ";
}
?>
<form method="post" action="update_photo_product.php" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?php if (isset($id)) {echo $id;}?>">
	<label for="new_ph">изберете нова снимка</label>
	<input type="file" name="photo" id="new_ph">	
	<input type="submit" name="submit" value="запиши">
</form>
<?php 
if (isset($_POST['submit'])) {
	$id = $_POST['id'];
} else {
	$id = '';
}
if(!empty($_FILES))		{
	if (!empty($_FILES['photo']['tmp_name'])) {
		$file_name = $_FILES['photo']['name'];
		$tmp_name = $_FILES['photo']['tmp_name'];
		$file_size = $_FILES['photo']['size'];
		$file_type = $_FILES['photo']['type'];
		$content = addslashes(file_get_contents($tmp_name));
//insering picture into the
		$q = "UPDATE `products` 
		SET `content_photo`='$content',
		`name_photo`='$file_name',
		`type_photo`='$file_type',
		`size_photo`='$file_size' 
		WHERE  `id` = $id";
		if (mysqli_query($connect, $q)) {
			echo "Успешно променихте снимката на рецептата!";
			$q = "SELECT `content_photo` FROM `products` WHERE id = $id";
			$result = mysqli_query($connect, $q);
			$row = mysqli_fetch_assoc($result);
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';
		}
	}
}
?>
<!--back to somewhere-->