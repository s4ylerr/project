0<?php 
$username = 'kokolina';
require_once('functions.php');
require_once('includes.php');
if(!empty($_GET)) {
	$product = $_GET['product'];
} else {
	$product = '';
} 	
//retrieving product info
$q = "SELECT * FROM `products` WHERE `product` = '$product'";
$result = mysqli_query($connect, $q);
if (mysqli_num_rows($result)>0) {
	$row = mysqli_fetch_assoc($result);
}
?>
<!-- to be deleted from here-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="jquery-1.11.3.min.js"></script>
</head>
<body>
	<form method="post" action="photo_product.php" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php  if (isset ($row['id'])){ echo $row['id']; }?>">
		<input type="hidden" name="product" value="<?php  if (isset ($product)){ echo $product; }?>">
		<label for="ph">изберете снимка</label>
		<input type="file" name="photo" id="ph">
		<input type="submit" name="submit" value="запиши" >
	</form>
	<?php 
		/*$q_new_info = "UPDATE `products` 
						SET `product`='$product',
						`calories`=$cal,
						`gi`=$gi
						WHERE `id` = $id";*/
						if (isset($_POST['submit'])) {
							$id = $_POST['id'];
							$product = $_POST['product'];

							if(!empty($_FILES))		{	


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
								WHERE `id` = $id";

								if (mysqli_query($connect, $q)) {
									echo "Успешно записахте снимка на продукта";
									$q = "SELECT `content_photo` FROM `products` WHERE id = $id";
									$result = mysqli_query($connect, $q);
									$row = mysqli_fetch_assoc($result);
									echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';

								} else {
									echo "Опитайте отново!";
								}

							}
						}

						?>
						<a href="update_photo_product.php?id=<?php echo $id;?>">променете снимката</a>			
					</body>
					</html>