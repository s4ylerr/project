<?php 
header('Content-Type: text/html; charset=utf-8'); 
$connect = mysqli_connect('localhost', 'root', '', 'foods_project'); 
	if (!$connect) {
		die ("Connection failed: mysqli_connect_error()");
	} else {
		echo "Connected successfully<br />";
	}
	if (!empty($_GET)) {
		$id_rec = $_GET['id_rec'];
	

$q = "SELECT `content_photo` FROM `recipes` WHERE id = $id_rec";
$result = mysqli_query($connect, $q);
$row = mysqli_fetch_assoc($result);
echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';
} else {
		$id_rec = " ";
	}
?>
<form method="post" action="update_photo_recipe.php" enctype="multipart/form-data">
<input type="hidden" name="id_rec" value="<?php if (isset($id_rec)) {echo $id_rec;}?>">
<label for="new_ph">изберете нова снимка</label>
<input type="file" name="photo" id="new_ph">	
<input type="submit" name="submit" value="запиши">
</form>
<?php 
if (isset($_POST['submit'])) {
	$id_rec = $_POST['id_rec'];
} else {
	$id_rec = '';
}
if(!empty($_FILES))		{
			if (!empty($_FILES['photo']['tmp_name'])) {
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

				if (mysqli_query($connect, $q)) {
					echo "Успешно променихте снимката на рецептата!";
				}
			}
		}


?>
<!--back to somewhere-->