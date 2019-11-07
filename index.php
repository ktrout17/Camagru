<?php 
	require "header.php";
?>
	<html>
	<link rel="stylesheet" href="style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<?php	
		if(isset($errormsg))	
			echo '<div style="color:#FF0000;text-align:center;font-size:18px;">'.$errormsg.'</div>';
	?>
	<body>
	<div align="center">
		<div class="login">
			<?php
				if(isset($errormsg))
					echo '<div style="color:#20b2aa;text-align:center;font-size:17px;">'.$errormsg.'</div>';
				if (isset($_SESSION['id']))
					echo '<li><a href="logout.php">Logout</a></li>';
				else {
					echo '<p class="login-status">You are not logged in</p>';
				}
			?>
			<div style="font-size:30px;color:cadetblue">Welcome Back!</div>
			<br>
			<br>
			<form action="login.php" method="post">
				<input type="text" name="username" placeholder="Username/E-mail" value="<?php if(isset($_POST['username'])) echo $_POST['username'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box"/><br /><br />
				<input type="password" name="password" placeholder="Password" value="<?php if(isset($_POST['password'])) echo $_POST['password'] ?>" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');"  class="box" /><br/><br />
				<input type="submit" name="login-submit" value="Login" class="submit"/><br />
				<div style="color:cadetblue;text-decoration:white">Don't have an account? Create one <a href="signup.php">here</a></div>
				<div style="color:cadetblue;text-decoration:white"><a href="forgot_pwd.php">I forgot my password</a></div>
			</form>
		</div>
	</div>
	</body>	
	</html>

<?php
	require "footer.php";
?>