<?php
	require_once('template/header.php');
	$error = 0;
	if (isset($_POST['submit'])) {
		
		$email = trim(htmlspecialchars($_POST['email']));
		$name = trim(htmlspecialchars($_POST['name']));
		$subject = trim(htmlspecialchars($_POST['subject']));
		$msg = trim(htmlspecialchars($_POST['msg']));
		$date = date('Y-m-d');
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){

			if (strlen($name) > 2) {
				
				if (strlen($subject) > 2) {
					
					if (strlen($msg) > 0) {
						
						echo '<p class="msg bg-success">Благодарим Ви за съобщението! Ще Ви отговорим възможно най-бързо!</p>';

					}else{
						$error = 4;
					}

				}else{
					$error = 3;
				}

			}else{
				$error = 2;
			}

		}else{

			$error = 1;	

		}

	}


?>
						<div class="contacts">
							<form method="post" action="">
							  <div class="form-group has-error">
								  <label class="control-label" for="inputSuccess1">Email адрес</label>
								  <?php
								  	if (is_numeric($error) AND $error == 1) {
								  		?>
								  			<p class="msg bg-danger">Моля въведете валиден Email адрес</p>
								  		<?php
								  	}
								  ?>

								  <input name="email" type="email" class="form-control" for="inputError1" placeholder="Email адрес" />

								</div>
							  <div class="form-group has-error">
							    <label class="control-label" for="inputSuccess1">Име</label>
							    <?php
								  	if (is_numeric($error) AND $error == 2) {
								  		?>
								  			<p class="msg bg-danger">Моля въведете по дълго име</p>
								  		<?php
								  	}
								  ?>
							    <input name="name" type="text" class="form-control" for="inputError1" placeholder="Име">

							  </div>
							  <div class="form-group has-error">
							    <label class="control-label" for="inputSuccess1">Тема</label>
							    <?php
								  	if (is_numeric($error) AND $error == 3) {
								  		?>
								  			<p class="msg bg-danger">Моля въведете тема на съобщението</p>
								  		<?php
								  	}
								  ?>
							    <input name="subject" type="text" class="form-control" for="inputError1" placeholder="Тема на съобщението">

							  </div>
							  <div class="form-group has-error">
								  <label class="control-label" for="inputSuccess1">Съобщение</label>
								  <?php
								  	if (is_numeric($error) AND $error == 4) {
								  		?>
								  			<p class="msg bg-danger">Моля въведете Съобщение</p>
								  		<?php
								  	}
								  ?>
								  <textarea name="msg" class="form-control" rows="3">Съобщение</textarea>

							  </div>
							 
							  <button name="submit" type="submit" class="btn btn-default">Submit</button>
							</form>
						</div>
		

<?php
	require_once('template/footer.php');
?>