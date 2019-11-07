<?php
	require 'header.php';
	require 'config/database.php';
	if (empty($_SESSION['username']))
		header("Location: login.php");
?>

<html>
<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="style.css">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
</head>
<body>
	<div align="center">
		<?php
			if (isset($errormsg))
			echo '<div style="color:#FF0000;text-align:center;font-size:17px;">'.$errMsg.'</div>';
		?>
		<div style="background-color:cadetblue; color:#FFFFFF; padding:10px;"><b><?php echo $_SESSION['username']; ?></b></div>
			<div style="margin: 15px">
				Welcome <?php echo $_SESSION['username']; ?> <br>
				<a href="update.php">Update</a> <br>
				<a href="logout.php">Logout</a>
			</div>
	</div>
</body>
</html>

<?php
	require 'footer.php';
?>