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
		<div style="color:burlywood; padding:10px;font-size:25px;"><b>Welcome Back, <?php echo $_SESSION['username']; ?></b></div>
			<div class="container">
				<main>
					<div class="row">
						<div class="left">
							<div class="photo-left">
								<img class="profile" src="img/profile.png" alt="profile pic"/>
								<div class="active"></div>
							</div>
							<h4 class="name"><?php echo $_SESSION['username']?></h4>
							<p class="info"><?php echo $_SESSION['email']?></p>
							<p class="info">Verified User</p>
						</div>
						<div class="right">
							<ul class="nav">
								<li>Gallery</li>
								<li>Comments</li>
								<li><a href="update.php">Update Account</li></a>
							</ul>
						</div>
					</div>
				</main>
			</div>
	</div>
	
<?php
	require 'footer.php';
?>