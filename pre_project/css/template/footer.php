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