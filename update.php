<?php
	session_start();
	require 'config/database.php';
	require 'style/header.php';
	include 'editing/functions.php';

	if (empty($_SESSION['username']))
		header("Location: login.php");

	$curr_email = $_SESSION['email'];
	$curr_username = $_SESSION['username']; 
	$notify = notify_comments();

?>

<html>
	<link rel="stylesheet" href="style/style.css">
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
			<div style="color:burlywood;font-size:20px">Would you like to be notified when someone comments on your pictures?</div>
			<form id="notify_form" action="includes/comments_notification.inc.php" method="post">
				<?php if ($notify == 'yes') { ?>
					<input class="box" type="checkbox" name="mail-notify" checked="true" onclick="com_not()">
					<br>
					<div style="color:cadetblue;font-size:15px">Disable Notifications</div>
				<?php } else { ?>
					<input class="box" type="checkbox" name="mail-notify" onclick="com_not()">
					<br>
					<div style="color:cadetblue;font-size:15px">Enable Notifications</div>
				<?php } ?>
			</form>
		</div>
	</div>
	</body>	
	<script>
		function com_not() 
		{
			document.getElementById('notify_form').submit();
		}
	</script>
</html>

<?php
	require 'style/footer.php';
?>