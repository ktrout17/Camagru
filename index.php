<?php 
	require "header.php";
?>
	<html>
	<link rel="stylesheet" href="style.css">
	<?php	
		if(isset($errMsg))	
			echo '<div style="color:#FF0000;text-align:center;font-size:18px;">'.$errormsg.'</div>';
	?>
	<body>
	<div align="center">
		<div class="login">
			<?php
				if(isset($errMsg))
					echo '<div style="color:#20b2aa;text-align:center;font-size:17px;">'.$errMsg.'</div>';
			?>
			<div style="font-size:30px;color:cadetblue">Welcome Back!</div>
			<br>
			<br>
			<form action="" method="post">
				<input type="text" name="username" placeholder="username" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box"/><br /><br />
				<input type="password" name="password" placeholder="password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<input type="submit" name="login" value="Login" class="submit"/><br />
			</form>
		</div>
	</div>
	</body>	
	</html>

<?php
	require "footer.php";
?>