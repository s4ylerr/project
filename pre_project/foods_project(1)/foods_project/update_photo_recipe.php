<?php 
require_once('template/header.php');
require_once('functions.php');
require_once('includes.php');
if (!empty($_GET)) {
	$id_rec = $_GET['id_rec'];
	?>
	<div class="row updatep" style="background-image:url('images/images.jpg')";>	
		<div class="first_enterd  text-center  col-xs-8 col-xs-offset-2">
			<div class="photo">

				<?php
				$q = "SELECT `content_photo` FROM `recipes` WHERE id = $id_rec";
				$result = mysqli_query($connect, $q);
				$row = mysqli_fetch_assoc($result);
				echo '<img class="img-thumbnail img-responsive" src="data:image/jpeg;base64,'.base64_encode( $row['content_photo'] ).'"/>';
			} else {
				$id_rec = " ";
			}
			?>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1">
				<form method="post" action="" enctype="multipart/form-data" class="rd form-horizontal">
					<div class="row form-group">
						<div class="new_ph col-xs-6 col-xs-offset-3">
							<label  for="new_ph">ИЗБЕРЕТЕ НОВА СНИМКА</label>
							<input type="file" name="photo" id="new_ph">	
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-6 col-xs-offset-3">
							<button type="submit" name="submit" class="btn btn-primary">ЗАПИШИ</button>	
						</div>
					</div>
					<div>

						<div class="col-xs-6 col-xs-offset-3">
							<a href="calculations.php?displayr=<?php echo $_GET['id_rec']; ?>&num=<?php echo $_GET['num']; ?>" class="btn btn-info active" role="button">ПРЕГЛЕДАЙ</a>										
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>
</div>

<?php 
if (isset($_POST['submit'])) {
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
			WHERE  `id` = '$_GET[id_rec]'";
			if (mysqli_query($connect, $q)) {
				echo "<div class'row'><div class='col-xs-8 col-xs-offset-2'><p class='bg-info text-primary'>Успешно променихте снимката на рецептата!</p></div></div>";
			}
		}
	}
}
require_once('template/footer.php');
?>
<!--back to somewhere-->