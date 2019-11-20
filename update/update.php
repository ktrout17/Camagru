<?php
	session_start();
	require '../config/database.php';
	require '../style/header.php';

	if (empty($_SESSION['username']))
		header("Location: login.php");

	$curr_email = $_SESSION['email'];
	$curr_username = $_SESSION['username']; 

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
		<div class="update">
			<?php
				if(isset($errormsg))
					echo '<div style="color:#20b2aa;text-align:center;font-size:17px;">'.$errormsg.'</div>';
			?>
			<div style="font-size:30px;color:burlywood">Update Your Info</div>
			<br>
			<br>
			<input type="text" name="username" placeholder="Username" value="<?php echo $curr_username; ?>" readonly autocomplete="off" />
			<a href="update_user.php"><input type="button" name="update_user" value="Change"/></a>
			<input type="text" name="email" placeholder="Email" value="<?php echo $curr_email; ?>" readonly autocomplete="off"  />
			<a href="update_email.php"><input type="button" name="update_email" onclick="window.location.href = 'update_email.php'" value="Change"/></a>
			<br>
			<div style="color:burlywood;font-size:20px">Would you like to change your password?</div>
			<a href="update_pwd.php"><input type="button" name="update_password" onclick="window.location.href = 'update_pwd.php'" value="Change Password"/></a>
		</div>
	</div>
	</body>	
</html>

<?php
	require '../style/footer.php';
?>