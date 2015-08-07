<?php
session_start();
require_once('config.php'); // инклудвам конфигурационния файл, защото ще ползвам mysqli база данни
$filename = basename($_SERVER['REQUEST_URI'], '?'.$_SERVER['QUERY_STRING']);
if (!$_SESSION) {
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="js/js-image-slider.js" type="text/javascript"></script>
    <link href="css/generic.css" rel="stylesheet" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!--JQuery CDN-->
	<script src="jquery-1.11.3.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	

	<title>Регистрация - Рецептите</title>

</head>
	<body>



		<div class="container">
	<div class="row">
		<div class="header col-md-12 just">
			<div class="row">
			<a href="index.php">
				<div class="head col-xs-4">
					<div class="header_text">
						
					</div>
				</div>
			</a>
				<div class="header_reg_log_search col-md-4 col-md-offset-4">
					

					<div class="row">
					  
					  <div class="col-lg-6">
					    <div class="input-group">
					       <form method="get" action="search.php">
					      <input name="search" type="text" class="form-control" placeholder="Search">
					      <span class="input-group-btn">
					        <button name="submit" value="search" class="btn btn-default" type="submit">Go!</button>
					      </span>
					    </form>


					      

					    </div><!-- /input-group -->
					    
					  </div><!-- /.col-lg-6 -->
					  
					  <?php

								if ($_SESSION) {
									$select_user_info = "SELECT * FROM users 
									JOIN user_info ON users.id = user_info.id_user 
									WHERE users.username = '$_SESSION[user]'";
									$query_info = mysqli_query($connect, $select_user_info)or die(mysqli_error());
									$row = mysqli_fetch_assoc($query_info);
									echo "<a href='main.php'>";

									if ($row['profile_picture']) {
										echo '<img width="50" src="data:image/jpeg;base64,'.base64_encode( $row['profile_picture'] ).'"/> ';
									}
									
									
									// echo '<a href="' . $row['profile_picture'] . '"></a>';
									echo  $_SESSION['user'] . '</a>!';
									echo ' <a title="Изход" href="logout.php">Изход</a>';
								}else{
									echo "<span class='glyphicon glyphicon-plus'></span> <a title='Регистрация' href='register.php'> Регистрация </a> ";
									echo " <span class='glyphicon glyphicon-user'></span> <a title='Вход' href='login.php'> Вход</a>";

								}
								
							?>	

					</div><!-- /.row -->


				</div>
			</div>
			
		</div>
	</div>
		<div class="row">
			<div class="col-md-12 just">
				<div class="first text-center col-xs-12">
					<div class="row">
						<div class="newclas col-xs-12">						

								
								<!--                започва менюто			-->

									<ul class="nav nav-tabs">
									<?php

										$q_menu = "SELECT * FROM menu";
										$sql_menu = mysqli_query($connect, $q_menu)or die(mysqli_query());

										if (mysqli_num_rows($sql_menu) > 0) {

											while ($res = mysqli_fetch_assoc($sql_menu)) {

												if ($filename == $res['link']) {
													
													echo "<li class='active' role='presentation'><a href=";
													echo $res['link'];
													echo ">";
													echo $res['name_menu'];
													echo "</a></li>";

												}else{ 
													echo "<li role='presentation'><a href=";
													echo $res['link'];
													echo ">";
													echo $res['name_menu'];
													echo "</a></li>";
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


		<form method="post" action="">

			<table id="register_table">

				<tr>
					<td class="uppercase_text" colspan="2">Регистрация</td>
				</tr>

				<?php
					// започвам php кода вътре във формата и таблицата за да отпечатвам отговорите вътре в таблицата за по-прегледно
					
					if (isset($_POST['submit'])) { // правя проверка дали е натиснат бутона "Регистрация" от формата
						
						echo '<tr>';

						// htmlspecialchars - премахва специалните знаци, trim - премахва празните пространства

						$username		=		trim(htmlspecialchars($_POST['username']));
						$pass1			= 		trim(htmlspecialchars($_POST['pass1']));
						$pass2			= 		trim(htmlspecialchars($_POST['pass2']));
						$email 			= 		trim(htmlspecialchars($_POST['email']));

						$query_check = "SELECT username FROM users WHERE username = '$username'";
						$chek_username  = 		mysqli_query($connect, $query_check) or die (mysqli_error());;
						$numUsers 		= 		mysqli_num_rows($chek_username);

						$queryi_email = "SELECT email FROM users WHERE email = '$email'";
						$chek_email 	= 		mysqli_query($connect, $queryi_email) or die (mysqli_error());
						$numEmail 		= 		mysqli_num_rows($chek_email);

						$date 			= 		date("j.n.Y");

						if (strlen($username) > 2) { // проверяваме за дължината на потребителското име

							if ($numUsers == 0) { // проверяваме дали не съществува потребител със същото име в системата

								if (strlen($pass1) > 2) { // проверяваме дължината на първата парола
									
									if (strlen($pass2 > 2)) { // проверяваме за дължината и на втората парола
										
										if ($pass1 == $pass2) { // проверяваме дали въведените пароли съвпадат
											
											if (filter_var($email, FILTER_VALIDATE_EMAIL)) { // проверява дали паролата е валидна

											    if ($numEmail == 0) { // проверяваме дали съществува такъв емейл в системата

											    	$pass1 = sha1($pass1); // криптираме паролата преди да се запише в базата данни

											    	$query_insert = "INSERT INTO users 
											    		(username, email, password, date) 

											    		VALUES 

											    		('$username', '$email', '$pass1', '$date')";
											    	$success = mysqli_query($connect, $query_insert) or die (mysqli_error());

											    	echo '<td colspan="2"><p class="success">Успешно се регистрира в системата!</p>
											    	<p class="success"><a href="login.php">Вход в сайта!</a></p>
											    	</td>';

											    }else{

											    	echo '<td colspan="2"><p class="error">Този email адрес вече се ползва в системата!</p></td>';

											    }												

											}else{

												echo '<td colspan="2"><p class="error">Моля, въведете валиден email адрес!</p></td>';

											}

										}else{

											echo '<td colspan="2"><p class="error">Паролите не съвпадат!</p></td>';

										}

									}else{

										echo '<td colspan="2"><p class="error">Моля, повторете с по-дълга парола. Поне 4 символа!</p></td>';

									}

								}else{

									echo '<td colspan="2"><p class="error">Моля, въведете по-дълга парола. Поне 4 символа!</p></td>';

								}							
							}else{

								echo '<td colspan="2"><p class="error">Това потребителско име вече съществува!</p></td>';

							}
						}else{

							echo '<td colspan="2"><p class="error">Моля, въведете по-дълго потребителско име!</p></td>';

						}

						echo '</tr>';

					}


				?>
				<tr>
					<td>Потребителско име:</td><td><input type="text" name="username" value="" /></td>
				</tr>

				<tr>
					<td>Парола:</td><td><input type="password" name="pass1" value="" /></td>
				</tr>

				<tr>
					<td>Повтори паролата:</td><td><input type="password" name="pass2" value="" /></td>
				</tr>

				<tr>
					<td>Email:</td><td><input type="text" name="email" value="" /></td>
				</tr>

				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Регистрация" /></td>
				</tr>

			</table>
		</form>
	<div class="row">
  <div class="footer col-xs-12">
  	<ul class="footer_menu">
  <?php
  $footer_menu = "SELECT * FROM menu";
  $select_footer_menu = mysqli_query($connect, $footer_menu)or die(mysqli_error());
  if (mysqli_num_rows($select_footer_menu) > 0) {
  	
  	while ($row_footer_menu = mysqli_fetch_assoc($select_footer_menu)) {
  		
  		echo '<li>< <a href="'.$row_footer_menu['link'].'">'.$row_footer_menu['name_menu'].'</a></li>';

  	}

  }
  ?>
  </ul>


  </div>
</div>

</div>

	
</body>
</html>
<?php
}
else{

	header('Location: index.php'); // логнал се потребител се опитва да влезе в register.php

}